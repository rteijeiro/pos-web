<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <script>
      //asynchronous function
      async function loadSubcategory(category) {
        //declare the object
        var dataFake = {
          refrescos: ["Agua", "Zumo de piña", "Fanta", "Coca cola"],
          vinos: ["Vino tinto", "Vino rosado"],
          pescados: [
            "Merluza a la romana",
            "Bacalao al horno",
            "Bacalao a la vizcaína",
            "Bacalao al espeto",
            "Bonito",
            "Lubina a la espalda",
            "Ostras",
          ],
          mariscos: [
            "Gambas al ajillo",
            "Langosta a la plancha",
            "Langonstinos",
            "Mejillones en salsa",
          ],
        };
        try {
          //fetch url
          let url = `http://localhost/<Page>?category=${category}`;

          //this is fetch
          /*let response = await fetch(url);
          let data = await response.json();
            */

          //clear old content
          let subcategoryDiv = document.getElementById(
            "subcategory-" + category
          );
          subcategoryDiv.innerHTML = "";

          //browse the items in the dataFake category
          //data.forEach((item) => {
          dataFake[category].forEach((item) => {
            let div = document.createElement("div");
            div.classList.add("item");
            div.textContent = item;
            subcategoryDiv.appendChild(div);
          });

          //show subcategory
          toggleSubcategory("subcategory-" + category);
        } catch (error) {
          console.error("Error cargando los datos:", error);
        }
      }
      //show and hide subcategories
      function toggleSubcategory(id) {
        let subcategories = document.querySelectorAll(".subcategory");
        subcategories.forEach((sub) => {
          if (sub.id !== id) {
            sub.style.display = "none";
          }
        });
        let subcategory = document.getElementById(id);
        subcategory.style.display =
          subcategory.style.display === "none" ||
          subcategory.style.display === ""
            ? "flex"
            : "none";
      }
    </script>
    <style>
      body {
        font-family: Arial, sans-serif;
      }
      .categories {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding: 10px;
      }
      .category {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
        border-radius: 10px;
        background-color: #f5f5f5;
        cursor: pointer;
        text-align: center;
      }
      .category img {
        width: 50px;
        height: 50px;
      }
      .subcategory {
        display: none;
        flex-direction: column;
        gap: 10px;
        padding: 10px;
      }
      .item {
        cursor: pointer;
        padding: 5px;
        border: 1px solid #ddd;
        background: #fafafa;
        border-radius: 5px;
      }
    </style>
  </head>
  <body>
    <div class="categories">
      <div class="category" onclick="loadSubcategory('refrescos')">
        <img src="" alt="" /><span>Refrescos</span>
      </div>
      <div class="category" onclick="loadSubcategory('vinos')">
        <img src="" alt="" /><span>Vinos</span>
      </div>
      <div class="category" onclick="loadSubcategory('pescados')">
        <img src="" alt="" /><span>Pescados</span>
      </div>
      <div class="category" onclick="loadSubcategory('mariscos')">
        <img src="" alt="" /><span>Marisco</span>
      </div>
    </div>

    <div id="subcategory-refrescos" class="subcategory"></div>
    <div id="subcategory-vinos" class="subcategory"></div>
    <div id="subcategory-pescados" class="subcategory"></div>
    <div id="subcategory-mariscos" class="subcategory"></div>
  </body>
</html>
