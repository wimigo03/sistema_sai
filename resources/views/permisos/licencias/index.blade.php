<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Handlebars Example</title>
  <script src="https://cdn.jsdelivr.net/npm/handlebars/dist/handlebars.min.js"></script>
</head>
<body>
  <h1>Handlebars Example</h1>

  <script id="example-template" type="text/x-handlebars-template">
    @verbatim
      <div class="example">
        <p>This is a Handlebars template example</p>
        <p>{{variable}}</p>
      </div>
    @endverbatim
  </script>

  <div id="output">

  </div>

  <script>
    const data = {
      variable: "Hello, Handlebars!"
    };

    const templateSource = document.getElementById("example-template").innerHTML;
    const template = Handlebars.compile(templateSource);
    const renderedHTML = template(data);

    document.getElementById("output").innerHTML = renderedHTML;
  </script>
</body>
</html>
