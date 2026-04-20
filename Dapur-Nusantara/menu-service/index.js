const express = require("express");
const cors = require("cors");
const bodyParser = require("body-parser");
const path = require("path");

const { getMenus, getMenuById, createMenu, updateMenu, deleteMenu } = require("./menuResolver");

const app = express();

app.use(cors());
app.use(bodyParser.json());

app.use("/images", express.static(path.join(__dirname, "images")));

app.get("/menus", getMenus);
app.get("/menus/:id", getMenuById);
app.post("/menus", createMenu);
app.put("/menus/:id", updateMenu);
app.delete("/menus/:id", deleteMenu);

app.listen(3003, () => {
  console.log("🍽️ Menu Service running on http://localhost:3003");
});
