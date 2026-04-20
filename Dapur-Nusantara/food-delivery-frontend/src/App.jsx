import { useState, useEffect } from 'react'
import Header from './components/Header'
import HeroBanner from './components/HeroBanner'
import MenuSection from './components/MenuSection'
import CartBox from './components/CartBox'
import AuthModal from './components/AuthModal'
import OrderHistoryModal from './components/OrderHistoryModal'
import OrderTypeModal from './components/OrderTypeModal'
import './App.css'

const GRAPHQL_URL = window.location.port === '80' || window.location.port === ''
  ? '/graphql'
  : 'http://localhost:4000/graphql';

const IMAGE_BASE_URL = window.location.port === '80' || window.location.port === ''
  ? '/images'
  : 'http://localhost:3003/images';

async function graphqlQuery(query, variables = {}) {
  try {
    const response = await fetch(GRAPHQL_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ query, variables }),
    });
    const result = await response.json();
    if (result.errors) throw new Error(result.errors[0].message);
    return result.data;
  } catch (error) {
    console.error('GraphQL Error:', error);
    throw error;
  }
}

function App() {
  const [menus, setMenus] = useState([])
  const [cart, setCart] = useState([])
  const [currentUser, setCurrentUser] = useState(null)
  const [authModalOpen, setAuthModalOpen] = useState(false)
  const [authMode, setAuthMode] = useState('login')
  const [customerName, setCustomerName] = useState('')
  const [customerAddress, setCustomerAddress] = useState('')
  const [searchQuery, setSearchQuery] = useState('')
  const [orderHistory, setOrderHistory] = useState([])
  const [showHistoryModal, setShowHistoryModal] = useState(false)

  // Order type state — terintegrasi penuh
  const [orderType, setOrderType] = useState(null)           // 'delivery' | 'takeaway' | null
  const [pickupPlate, setPickupPlate] = useState('')         // untuk takeaway
  const [showOrderTypeModal, setShowOrderTypeModal] = useState(false)

  useEffect(() => { loadMenus() }, [])

  const loadMenus = async () => {
    try {
      const result = await graphqlQuery(`
        query GetMenus {
          getMenus { id name price image }
        }
      `)
      setMenus(result.getMenus || [])
    } catch (e) {
      console.error('Menu server offline:', e)
    }
  }

  const addToCart = (menu) => {
    setCart(prev => {
      const existing = prev.find(i => i.id === menu.id)
      if (existing) return prev.map(i => i.id === menu.id ? { ...i, qty: i.qty + 1 } : i)
      return [...prev, { ...menu, qty: 1 }]
    })
  }

  const updateQty = (id, delta) => {
    setCart(prev => {
      const item = prev.find(i => i.id === id)
      if (!item) return prev
      const newQty = item.qty + delta
      if (newQty <= 0) return prev.filter(i => i.id !== id)
      return prev.map(i => i.id === id ? { ...i, qty: newQty } : i)
    })
  }

  const handleLogin = async (email, password) => {
    try {
      const result = await graphqlQuery(`
        mutation Login($email: String!, $password: String!) {
          login(email: $email, password: $password) {
            message id name email address
          }
        }
      `, { email, password })
      const data = result.login
      if (!data || !data.id) throw new Error(data?.message || 'Gagal Login')
      setCurrentUser(data)
      setCustomerName(data.name || '')
      setCustomerAddress(data.address || '')
      setAuthModalOpen(false)
      alert('Login Berhasil! Selamat datang, ' + data.name)
    } catch (e) {
      alert(e.message || 'Gagal konek ke server')
    }
  }

  const handleSignup = async (name, email, password, address) => {
    try {
      const result = await graphqlQuery(`
        mutation CreateUser($name: String!, $email: String!, $password: String!, $address: String) {
          createUser(name: $name, email: $email, password: $password, address: $address) {
            id name email address
          }
        }
      `, { name, email, password, address: address || '' })
      const data = result.createUser
      if (!data || !data.id) throw new Error('Gagal membuat akun')
      setCurrentUser(data)
      setCustomerName(data.name || name)
      setCustomerAddress(data.address || address || '')
      setAuthModalOpen(false)
      alert('Akun berhasil dibuat! Selamat datang, ' + name)
    } catch (e) {
      alert(e.message || 'Gagal konek ke server')
    }
  }

  const handleLogout = () => {
    if (window.confirm('Apakah Anda yakin ingin logout?')) {
      setCurrentUser(null)
      setCustomerName('')
      setCustomerAddress('')
      setPickupPlate('')
      setOrderHistory([])
      setCart([])
      setOrderType(null)
    }
  }

  // Handle pemilihan order type dari hero banner — langsung buka modal detail
  const handleSelectOrderType = (type) => {
    setOrderType(type)
    setShowOrderTypeModal(true)
  }

  // Handle konfirmasi dari OrderTypeModal
  const handleOrderTypeConfirm = ({ type, address, plate }) => {
    setOrderType(type)
    if (type === 'delivery') {
      setCustomerAddress(address)
      setPickupPlate('')
    } else {
      setPickupPlate(plate)
      setCustomerAddress('')
    }
    setShowOrderTypeModal(false)
  }

  const loadOrderHistory = async () => {
    if (!currentUser) return;
    try {
      const result = await graphqlQuery(`
        query GetOrders($userId: ID) {
          getOrders(user_id: $userId) {
            id order_id user_id order_date total order_type pickup_number menu_id qty
            menu { name }
          }
        }
      `, { userId: String(currentUser.id) })
      if (result.getOrders) {
        setOrderHistory(result.getOrders)
      }
    } catch (e) {
      console.error('Failed to load history:', e)
    }
  }

  const confirmOrder = async () => {
    if (!currentUser) {
      alert('Silakan login terlebih dahulu!')
      setAuthMode('login')
      setAuthModalOpen(true)
      return
    }
    if (!orderType) {
      alert('Pilih metode pesanan (Delivery / Takeaway) terlebih dahulu!')
      window.scrollTo({ top: 0, behavior: 'smooth' })
      return
    }
    if (!customerName) {
      alert('Mohon isi nama pemesan!')
      return
    }
    if (orderType === 'delivery' && !customerAddress) {
      alert('Mohon isi alamat pengiriman!')
      setShowOrderTypeModal(true)
      return
    }
    if (orderType === 'takeaway' && !pickupPlate) {
      alert('Mohon isi nomor plat kendaraan!')
      setShowOrderTypeModal(true)
      return
    }
    if (!cart.length) {
      alert('Keranjang masih kosong!')
      return
    }

    try {
      const orderPromises = cart.map(item => {
        return graphqlQuery(`
          mutation CreateOrder($userId: ID!, $menuId: ID!, $qty: Int!, $orderType: String) {
            createOrder(user_id: $userId, menu_id: $menuId, qty: $qty, order_type: $orderType) {
              id order_id user_id total order_type pickup_number
            }
          }
        `, {
          userId: currentUser.id.toString(),
          menuId: item.id.toString(),
          qty: item.qty,
          orderType: orderType
        })
      })

      await Promise.all(orderPromises)
      alert('🎉 Pesanan berhasil dikirim!')
      setCart([])
      loadOrderHistory() // Refresh history immediately
    } catch (e) {
      console.error('Order error:', e)
      alert('Gagal kirim pesanan: ' + e.message)
    }
  }

  const total = cart.reduce((sum, item) => sum + item.price * item.qty, 0)
  const filteredMenus = menus.filter(m => m.name.toLowerCase().includes(searchQuery.toLowerCase()))
  const cartIds = cart.map(i => i.id)

  return (
    <div className="app-wrapper">
      <Header
        currentUser={currentUser}
        onHistoryClick={() => { loadOrderHistory(); setShowHistoryModal(true); }}
        onLoginClick={() => { setAuthMode('login'); setAuthModalOpen(true); }}
        onSignupClick={() => { setAuthMode('signup'); setAuthModalOpen(true); }}
        onLogout={handleLogout}
      />

      <HeroBanner
        orderType={orderType}
        onSelectOrderType={handleSelectOrderType}
        onOpenOrderModal={() => setShowOrderTypeModal(true)}
        customerName={customerName}
      />

      <main className="main-container">
        {/* LEFT: MENU */}
        <div className="left-panel">
          <div className="menu-header">
            <h2 className="section-title">
              <span className="title-bar" />
              Menu Nusantara
            </h2>
            <div className="search-wrapper">
              <span className="search-icon">🔍</span>
              <input
                type="text"
                className="search-input"
                placeholder="Cari hidangan favoritmu..."
                value={searchQuery}
                onChange={e => setSearchQuery(e.target.value)}
              />
            </div>
          </div>

          <MenuSection
            menus={filteredMenus}
            imageBaseUrl={IMAGE_BASE_URL}
            onAddToCart={addToCart}
            cartIds={cartIds}
          />
        </div>

        {/* RIGHT: CART */}
        <div className="right-panel">
          <CartBox
            customerName={customerName}
            customerAddress={customerAddress}
            onNameChange={setCustomerName}
            onAddressChange={setCustomerAddress}
            cart={cart}
            total={total}
            orderType={orderType}
            pickupPlate={pickupPlate}
            onUpdateQty={updateQty}
            onConfirmOrder={confirmOrder}
            onOpenOrderModal={() => setShowOrderTypeModal(true)}
          />
        </div>
      </main>

      {/* ORDER TYPE MODAL */}
      {showOrderTypeModal && (
        <OrderTypeModal
          initialType={orderType || 'delivery'}
          savedAddress={customerAddress}
          savedPlate={pickupPlate}
          onClose={() => setShowOrderTypeModal(false)}
          onConfirm={handleOrderTypeConfirm}
        />
      )}

      {/* AUTH MODAL */}
      {authModalOpen && (
        <AuthModal
          mode={authMode}
          onClose={() => setAuthModalOpen(false)}
          onLogin={handleLogin}
          onSignup={handleSignup}
        />
      )}

      {/* HISTORY MODAL */}
      {showHistoryModal && (
        <OrderHistoryModal
          orders={orderHistory}
          menus={menus}
          onClose={() => setShowHistoryModal(false)}
        />
      )}
    </div>
  )
}

export default App
