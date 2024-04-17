<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Spatie\Backup\BackupDestination\Backup;
use Spatie\Backup\BackupDestination\BackupDestinationFactory;
use Spatie\Backup\Notifications\Notifiable;
use Spatie\Backup\Tasks\Backup\BackupJob;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use Spatie\DbDumper\Databases\PostgreSql;

use Spatie\Backup\Tasks\Restore\RestoreDbJob;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator as IteratorRecursiveDirectoryIterator;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use ZipArchive;

class BackupController extends Controller
{
    public function index()
    {

        // Ejecutar el comando backup:list y obtener la salida
        $output = Artisan::call('backup:list');

        // Obtener las líneas de salida como un array
        // Obtener las líneas de salida como un array
        $lines = explode("\n", trim(Artisan::output()));

        // Filtrar y procesar las líneas para obtener los detalles de la copia de seguridad
        $tableData = [];
        $columns = [];
        foreach ($lines as $index => $line) {
            if ($index === 1) {
                // Si es la segunda línea, obtener los nombres de las columnas
                $columns = array_map('trim', explode('|', $line));
            } elseif ($index > 1 && strpos($line, '|') === 0) {
                // Si es una línea válida de datos
                $rowData = array_map('trim', explode('|', $line));

                // Verificar si el número de columnas es igual al número de columnas de encabezado
                if (count($rowData) === count($columns)) {
                    // Asignar los datos a las columnas correspondientes
                    $rowData = array_combine($columns, $rowData);

                    // Agregar los datos al array de datos de la tabla
                    $tableData[] = $rowData;
                }
            }
        }


        //   dd($tableData);

        // Pasar los detalles de las copias de seguridad a la vista
        return view('backups.index', compact('tableData'));
    }
    public function backups()
    {
        // Obtener la lista de copias de seguridad almacenadas en el disco
        $backupDestinations = BackupDestinationFactory::createFromArray(config('backup.backup'));
        // Inicializar un array para almacenar todas las copias de seguridad
        $backups = [];

        // Iterar sobre cada instancia de BackupDestination
        foreach ($backupDestinations as $backupDestination) {
            // Obtener las copias de seguridad de cada BackupDestination
            $backups = $backupDestination->backups();
            // Verificar si hay archivos de copia de seguridad disponibles
            if ($backups->isEmpty()) {
                return response()->json([
                    'draw' => request()->input('draw'),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => []
                ]);
            }

            // Agregar los datos de cada copia de seguridad al array
            foreach ($backups as $backup) {
                $rutaArchivo = $backup->path();


                $nombreArchivo = basename($rutaArchivo);
                $backupsData[] = [
                    'nombre_archivo' => $nombreArchivo,
                    'fecha_creacion' => Carbon::parse($backup->date())->diffForHumans(),
                    'tamaño' => $backup = $this->formatSize($backup->size()),
                    'ruta' => $rutaArchivo,

                    // Puedes agregar más datos aquí según sea necesario
                ];
            }
        }

        // Devolver los datos en formato JSON
        return response()->json([
            'draw' => request()->input('draw'),
            'recordsTotal' => count($backupsData),
            'recordsFiltered' => count($backupsData),
            'data' => $backupsData
        ]);
    }



    public function descargarBackup(Request $request)
    {
        $nombreArchivo = $request->input('nombre_archivo');

        // Verificar si el archivo existe
        if (!Storage::disk('local')->exists('Laravel/' . $nombreArchivo)) {
            abort(404);
        }

        // Obtener la ruta completa del archivo
        $rutaArchivo = 'Laravel/' . $nombreArchivo;


        //dd($directorioArchivo);
        // Obtener el nombre del archivo sin el directorio
        $nombreDescarga = basename($rutaArchivo);

        // Descargar el archivo utilizando una respuesta de flujo
        return response()->streamDownload(function () use ($rutaArchivo) {
            $stream = Storage::disk('local')->readStream($rutaArchivo);
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, $nombreDescarga);
    }

    public function create()
    {
        // Ejecutar la copia de seguridad
        $backupJob = BackupJobFactory::createFromArray(config('backup'));
        $backupJob->run();


        return redirect()->route('backups.index')->with('success', 'Backup creado exitosamente.');
    }




    public function restoreStorageFromZip(Request $request)
    {
        // Validar si se ha enviado un archivo ZIP
        $zipFile = $request->file('zip_file');

        $messages = [
            'zip_file.required' => 'El archivo ZIP es requerido.',
            'zip_file.file' => 'El archivo debe ser un archivo.',
            'zip_file.mimes' => 'El archivo debe ser un archivo ZIP válido.',
            'zip_file.max' => 'El archivo ZIP no debe ser mayor de :max kilobytes.',
        ];

        $request->validate([
            'zip_file' => 'required|file|mimes:zip', // máximo 2MB
        ], $messages);



        if (!$request->hasFile('zip_file')) {
            return redirect()->back()->with('error', 'No se ha seleccionado ningún archivo ZIP.');
        }
        // Obtener el archivo ZIP subido
        $zipFile = $request->file('zip_file');
        //dd($zipFile);


        $resumen = $this->descomprimirZip($zipFile);

        // Redirigir de vuelta con el mensaje de resumen
        return redirect()->back()
            ->with('process_summary', $resumen);
        // ->with('process_DB', $mensaje);
    }
    public function restoreStorageFromBackup(Request $request)
    {
        // Validar si se ha enviado un archivo ZIP
        $zipFile = $request->file('backup_file');
        //   dd($zipFile);

        $messages = [
            'backup_file.required' => 'El archivo Backup es requerido.',
            'backup_file.file' => 'El archivo debe ser un archivo.',
        ];

        $request->validate([
            'backup_file' => 'required|file', // máximo 2MB
        ], $messages);



        if (!$request->hasFile('backup_file')) {
            return redirect()->back()->with('error', 'No se ha seleccionado ningún archivo Backup.');
        }
        // Obtener el archivo ZIP subido

        $backupFile = $request->file('backup_file');
        if ($backupFile) {
            // Almacena el archivo en la carpeta "backups" dentro del directorio "storage/app"
            $nombreArchivo = uniqid() . '.' . $backupFile->getClientOriginalExtension();

            // Obtén la ruta de la carpeta backups
            $directoryBackup = storage_path('app\backups');
            // Verificar si la carpeta temporal existe antes de intentar eliminarla
            if (File::exists($directoryBackup)) {
                // Eliminar la carpeta temporal y todo su contenido
                File::deleteDirectory($directoryBackup);
            }
            //  dd($directoryBackup);

            if (!File::exists($directoryBackup)) {
                // Crear el directorio con permisos de lectura y escritura
                File::makeDirectory($directoryBackup, 0777, true, true);
            }

            // dd($directoryBackup);


            $rutaCarpetaBackups = storage_path('app\backups');
            // dd($rutaCarpetaBackups);





            // Almacena el archivo con el nombre personalizado
            $rutaArchivo = storage_path($backupFile->storeAs('backups', $nombreArchivo));
            // dd($rutaArchivo);
            $process = $this->restaurarBaseDeDatos($rutaArchivo);
            if ($process->isSuccessful()) {
                // Si el proceso es exitoso, retornar un mensaje de éxito
                $mensaje =  "La restauración de la base de datos se ha completado exitosamente.";
            } else {
                // Si el proceso falla, obtener el mensaje de error
                $errorOutput = $process->getErrorOutput();
                // Lanzar una excepción con el mensaje de error
                $mensaje =  "Error durante la restauración de la base de datos: $errorOutput";
            }
            // Redirigir de vuelta con el mensaje de resumen
            return redirect()->back()
                ->with('process_summary', $mensaje);
            // $rutaArchivo contendrá la ruta donde se almacenó el archivo dentro del almacenamiento de Laravel
        } else {
            return redirect()->back()->with('error', 'Error al almacenar el archivo Backup.');
        }



        // ->with('process_DB', $mensaje);
    }


    public function restoreBackupZip(Request $request)
    {

        $request->validate([
            'ruta' => 'required'
        ]);
        // Nombre del archivo de copia de seguridad seleccionado
        $nombreArchivo = $request->input('ruta');
        //  dd($nombreArchivo);


        // dd($nombreArchivo);
        // Ruta completa al archivo de copia de seguridad
        $rutaArchivo = storage_path('app/' . $nombreArchivo);
        // dd($rutaArchivo);

        // Validar si se ha enviado un archivo ZIP
        $tipoMIME = mime_content_type($rutaArchivo);
        // dd($tipoMIME);

        // Verificar si el tipo MIME indica que es un archivo ZIP
        if ($tipoMIME !== 'application/zip') {
            return redirect()->back()->with('error', 'No es un archivo ZIP.');
        }
        // $backup = file_get_contents('app/backups');
        // Obtener el archivo ZIP 
        $zipFile = $rutaArchivo;


        $resumen = $this->descomprimirZip($zipFile);
        //dd( $resumen);




        // $resumen .= "Nombre de la carpeta: " . $nombreCarpeta . "\n";

        // Redirigir de vuelta con el mensaje de resumen
        return redirect()->back()
            ->with('process_summary', $resumen);
    }

    private function descomprimirZip($zipFile)
    {
        //dd($zipFile);
        $tempExtractPath = storage_path('app\temp_zip_extract');

        if (!File::exists($tempExtractPath)) {
            // Crear el directorio con permisos de lectura y escritura
            File::makeDirectory($tempExtractPath, 0777, true, true);
        }


        //  dd($tempExtractPath);
        // Crear una instancia de ZipArchive para descomprimir el archivo ZIP
        //  $file = File::exists($tempExtractPath);
        //dd($file);
        // Verificar si la carpeta temporal existe antes de intentar eliminarla
        if (File::exists($tempExtractPath)) {
            // Eliminar la carpeta temporal y todo su contenido
            File::deleteDirectory($tempExtractPath);
        }


        // dd($tempExtractPath);

        // Crear una ubicación temporal para extraer el archivo ZIP
        $res = $this->extraerArchivoZIP($zipFile,  $tempExtractPath);
        // Extraer el archivo ZIP en la ubicación temporal
        if ($res === false) {
            return redirect()->back()->with('error', 'Error al abrir el archivo ZIP.');
        }

        // Definir las carpetas de almacenamiento y sus directorios de destino


        // dd($res);
        // Verificar si el directorio no existe
        $directoryBackup = storage_path('app/backups');

        if (!File::exists($directoryBackup)) {
            // Crear el directorio con permisos de lectura y escritura
            File::makeDirectory($directoryBackup, 0777, true, true);
        }
       


        $storageDirectories = [
            //  $tempExtractPath .  '\db-dumps',
            $tempExtractPath .  preg_replace('/^[a-zA-Z]:/', '', public_path('public')),
        ];

        if (!File::exists($tempExtractPath)) {
            if (File::exists($tempExtractPath)) {
                // Eliminar la carpeta temporal y todo su contenido
                File::deleteDirectory($tempExtractPath);
            }
            return redirect()->back()->with('error', 'Copia de Seguridad no Válida.');
          
        }


        //dd($storageDirectories);

        $destinationDirectories = [
            //  storage_path('app/backups'),
            public_path('public')
        ];

        //  dd($destinationDirectories);
        // Definir el array para almacenar los detalles del proceso


        // Inicializar el contador de archivos restaurados
        $totalFilesCopiedOrMoved = 0;

        // Iterar sobre cada par de directorios
        // Iterar sobre cada par de directorios
        foreach ($storageDirectories as $index => $storageDirectory) {
            $destinationDirectory = $destinationDirectories[$index];
        
            // Verificar si el directorio de destino existe
        
        
            // Copiar o mover el directorio de origen al directorio de destino
            // Utiliza File::moveDirectory() para mover en lugar de File::copyDirectory() si deseas mover en lugar de copiar
            File::copyDirectory($storageDirectory, $destinationDirectory);
           // dd($storageDirectory);


            $totalFilesCopiedOrMoved += $this->countFilesRecursive($storageDirectory);
        }
        // Verificar si la carpeta temporal existe antes de intentar eliminarla
        if (File::exists($tempExtractPath)) {
            // Eliminar la carpeta temporal y todo su contenido
            File::deleteDirectory($tempExtractPath);
        }



        // Construir el mensaje de resumen
        return "Cantidad de archivos restaurados: " . $totalFilesCopiedOrMoved;
    }

    function countFilesRecursive($directory) {
        $totalFiles = 0;
        $files = File::allFiles($directory);
        foreach ($files as $file) {
            if ($file->isFile()) {
                $totalFiles++;
            }
        }
    
        $directories = File::directories($directory);
        foreach ($directories as $subdirectory) {
            $totalFiles += $this->countFilesRecursive($subdirectory);
        }
    
        return $totalFiles;
    }


    private function restaurarBaseDeDatos()
    {




        // $rutaArchivo = 'C:\xampp\htdocs\sistema_sai\storage\app\backups\postgresql-sai.backup';
        $directorio = storage_path('app/backups');
        // $tempExtractPath = storage_path('app/temp_zip_extract/db-dumps');

        if (!$directorio) {
            return redirect()->back()->with('error', 'No se encuentra el Directorio de la  Backup de la Base de Datos.');
            # code...
        }
        //  dd($tempExtractPath);
        // Obtener la lista de archivos en el directorio
        $archivos = File::files($directorio);
        // dd($archivos);
        if (!count($archivos) === 1) {
            return redirect()->back()->with('error', 'Error al abrir el archivo Backup de la Base de Datos.');
        }
        $nombreCompletoArchivo = pathinfo($archivos[0], PATHINFO_BASENAME);
        //   $contenido = file_get_contents($archivo);
        $archivo = storage_path('app/backups/' . $nombreCompletoArchivo);
        // dd($archivo);


        // Obtener la lista de archivos en el directorio
        //  $archivos = glob($rutaDirectorio . '/*');

        //  $this->updatePgpass();

        // Configurar el comando para restaurar la base de datos
        $directorioPostgreSQL = 'C:\Program Files (x86)\PostgreSQL\9.2\bin'; // Reemplaza con la ruta correcta

        $command = [
            'pg_restore',
            '--host', 'localhost',
            '--port=' . env('PORT'),
            '--username=' . env('DB_USERNAME'),
            '--dbname=' . env('DB_DATABASE'),
            '--no-password',
            '--clean',
            '--schema', 'public',
            '--verbose',
            $archivo,
        ];
        //  dd($command);

        // dd($command);
        // Crear un nuevo proceso
        $process = new Process($command);
        // Configurar el directorio de trabajo si es necesario
        $process->setWorkingDirectory($directorioPostgreSQL);

        // Iniciar el proceso
        $process->start();
        // Esperar a que el proceso termine
        $process->wait();

        // Verificar si el proceso fue exitoso
        if (File::exists($archivo)) {
            // Eliminar la carpeta temporal y todo su contenido
            File::deleteDirectory($archivo);
        }

        return $process;
    }

    public function updatePgpass()
    {
        // Genera el contenido de pgpass.conf
        $pgpassContent = "localhost:" . env('DB_PORT') . ":backup:" . env('DB_USERNAME') . ":" . env('PASSWORD') . "\n";
        // Reemplaza estos valores con tus datos reales obtenidos de la configuración de Laravel
        // Obtiene la ruta al directorio AppData del usuario actual
        $appDataDir = getenv('APPDATA');
        // dd($appDataDir);
        // Escribe el contenido en pgpass.conf
        if ($appDataDir) {
            // Define la ruta al archivo pgpass.conf en Windows
            $pgpassPath = $appDataDir . DIRECTORY_SEPARATOR . 'postgresql' . DIRECTORY_SEPARATOR . 'pgpass.conf';
            //  dd($pgpassContent);

            // Escribe el contenido en pgpass.conf
            File::put($pgpassPath, $pgpassContent);

            // Verifica si se escribió correctamente
            if (File::exists($pgpassPath)) {
                return 'pgpass.conf actualizado correctamente';
            } else {
                return 'Error al actualizar pgpass.conf';
            }
        } else {
            return 'No se pudo obtener la ruta al directorio AppData';
        }
    }


    function extraerArchivoZIP($zipFile, $tempExtractPath)
    {
        // Crear un objeto ZipArchive
        $zip = new ZipArchive;

        // Abrir el archivo ZIP
        if ($zip->open($zipFile) === TRUE) {
            // Iterar sobre cada archivo en el archivo ZIP
            for ($i = 0; $i < $zip->numFiles; $i++) {
                // Obtener el nombre del archivo
                $filename = $zip->getNameIndex($i);
                // Extraer el archivo al directorio temporal
                $zip->extractTo($tempExtractPath, $filename);
            }
            // Cerrar el archivo ZIP
            $zip->close();
            return true; // Devolver verdadero si la extracción fue exitosa
        } else {
            // Si hay un error al abrir el archivo ZIP, devolver falso
            return false;
        }
    }
    public function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $unitIndex = 0;
        while ($bytes >= 1024 && $unitIndex < count($units) - 1) {
            $bytes /= 1024;
            $unitIndex++;
        }

        return round($bytes, 2) . ' ' . $units[$unitIndex];
    }
}
