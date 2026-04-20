# Food Delivery Application - Dapur POCOLOCO

Aplikasi food delivery dengan arsitektur microservices menggunakan GraphQL sebagai API Gateway.

## Arsitektur

- **Frontend**: HTML/CSS/JavaScript dengan Nginx
- **Backend (GraphQL Gateway)**: Apollo Server pada port 4000
- **User Service**: REST API pada port 3001
- **Menu Service**: REST API pada port 3003
- **Order Service**: REST API pada port 3002
- **Database**: MySQL untuk setiap service

## Cara Menjalankan Aplikasi

### Opsi 1: Menjalankan dengan Docker (Recommended untuk Production)

#### Prerequisites
- Docker dan Docker Compose terinstall

#### Langkah-langkah

1. **Clone atau pastikan semua file sudah ada**

2. **Build dan jalankan semua services:**
   ```bash
   docker-compose up --build
   ```

3. **Akses aplikasi:**
   - Frontend: http://localhost
   - GraphQL Playground: http://localhost:4000/graphql
   - User Service: http://localhost:3001
   - Menu Service: http://localhost:3003
   - Order Service: http://localhost:3002

#### Menghentikan Services

```bash
docker-compose down
```

Untuk menghapus volumes (database data):
```bash
docker-compose down -v
```

---

### Opsi 2: Menjalankan Secara Lokal (Development)

#### Menggunakan Script Otomatis (Recommended)

Jalankan semua service sekaligus dengan script:

```bash
./start-local.sh
```

Script ini akan menjalankan:
- User Service (port 3001)
- Order Service (port 3002)
- Menu Service (port 3003)
- Backend GraphQL (port 4000)
- Frontend (port 8080)

Buka browser dan akses: **http://localhost:8080**

#### Menjalankan Manual

**1. Install dependencies (jika belum):**

```bash
# Backend
cd backend
npm install

# User Service
cd ../user-service
npm install

# Order Service
cd ../order-service
npm install

# Menu Service
cd ../menu-service
npm install
```

**2. Jalankan setiap service di terminal terpisah:**

**Terminal 1 - User Service:**
```bash
cd user-service
node index.js
```

**Terminal 2 - Order Service:**
```bash
cd order-service
node index.js
```

**Terminal 3 - Menu Service:**
```bash
cd menu-service
node index.js
```

**Terminal 4 - Backend GraphQL:**
```bash
cd backend
node index.js
```

**Terminal 5 - Frontend:**
```bash
cd food-delivery-frontend
node server.js
```

**3. Buka browser dan akses:** **http://localhost:8080**

---

## Struktur Project

```
.
├── backend/              # GraphQL Gateway
│   ├── schema/          # GraphQL schema definitions
│   └── index.js         # Apollo Server setup
├── user-service/        # User management service
├── menu-service/        # Menu management service
├── order-service/       # Order management service
├── food-delivery-frontend/  # Frontend application
├── docker-compose.yml   # Docker orchestration
└── start-local.sh       # Script untuk menjalankan lokal
```

## GraphQL Endpoints

### Queries
- `getUsers` - Mendapatkan semua user
- `getUser(id: ID!)` - Mendapatkan user by ID
- `getMenus` - Mendapatkan semua menu
- `getMenu(id: ID!)` - Mendapatkan menu by ID
- `getOrders` - Mendapatkan semua order
- `getOrder(id: ID!)` - Mendapatkan order by ID

### Mutations
- `createUser(name, email, password, address)` - Membuat user baru
- `login(email, password)` - Login user
- `createOrder(user_id, menu_id, qty)` - Membuat order baru

## Troubleshooting

### Untuk Development Lokal
- Pastikan semua port (3001, 3002, 3003, 4000, 8080) tidak digunakan oleh aplikasi lain
- Jika ada error, pastikan semua dependencies sudah terinstall dengan `npm install`
- Pastikan database MySQL sudah running dan database `user_db`, `menu_db`, `order_db` sudah dibuat

### Untuk Docker
- Jika container gagal start, cek logs dengan: `docker-compose logs [service-name]`
- Jika perlu rebuild dari awal: `docker-compose down -v && docker-compose up --build`
