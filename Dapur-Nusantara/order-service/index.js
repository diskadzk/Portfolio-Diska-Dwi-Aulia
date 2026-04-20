const express = require("express");
const cors = require("cors");
const bodyParser = require("body-parser");

const { getOrders, createOrder } = require("./orderResolver");

const app = express();
app.use(cors());
app.use(bodyParser.json());

app.get("/orders", getOrders);
app.post("/orders", createOrder);

app.listen(3002, () => {
  console.log("🧾 Order Service running on port 3002");
});
