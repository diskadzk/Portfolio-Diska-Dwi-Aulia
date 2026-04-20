let menus = [
  { id: 1, name: "Ayam Bakar Madu", price: 25000, image: "ayam-bakar-madu.jpg" },
  { id: 2, name: "Ayam Geprek Sambal Bawang", price: 20000, image: "ayam-geprek-sambal-bawang.jpg" },
  { id: 3, name: "Ayam Goreng Lengkuas", price: 23000, image: "ayam-lengkuas.jpg" },
  { id: 4, name: "Bakso Urat", price: 25000, image: "bakso-urat.jpg" },
  { id: 5, name: "Lele Goreng", price: 18000, image: "lele-goreng.jpg" },
  { id: 6, name: "Mie Ayam", price: 20000, image: "mie-ayam.jpg" },
  { id: 7, name: "Nasi Goreng", price: 20000, image: "nasi-goreng.jpg" },
  { id: 8, name: "Es Teh Manis", price: 5000, image: "es-teh-manis.jpg" },
  { id: 9, name: "Es Jeruk", price: 7000, image: "es-jeruk.jpg" }
];

exports.getMenus = (req, res) => {
  res.json(menus);
};

exports.getMenuById = (req, res) => {
  const menu = menus.find(m => m.id == req.params.id);
  if (!menu) return res.status(404).json({ message: "Menu not found" });
  res.json(menu);
};

exports.createMenu = (req, res) => {
  const { name, price, image } = req.body;
  if (!name || !price) {
    return res.status(400).json({ message: "Name and price are required" });
  }
  
  const newId = menus.length > 0 ? Math.max(...menus.map(m => m.id)) + 1 : 1;
  const newMenu = { id: newId, name, price, image: image || null };
  menus.push(newMenu);
  res.status(201).json(newMenu);
};

exports.updateMenu = (req, res) => {
  const { id } = req.params;
  const { name, price, image } = req.body;
  
  const menuIndex = menus.findIndex(m => m.id == id);
  if (menuIndex === -1) {
    return res.status(404).json({ message: "Menu not found" });
  }
  
  const updatedMenu = {
    ...menus[menuIndex],
    ...(name && { name }),
    ...(price !== undefined && { price }),
    ...(image !== undefined && { image })
  };
  
  menus[menuIndex] = updatedMenu;
  res.json(updatedMenu);
};

exports.deleteMenu = (req, res) => {
  const { id } = req.params;
  const menuIndex = menus.findIndex(m => m.id == id);
  
  if (menuIndex === -1) {
    return res.status(404).json({ message: "Menu not found" });
  }
  
  menus.splice(menuIndex, 1);
  res.json({ message: "Menu deleted successfully" });
};
