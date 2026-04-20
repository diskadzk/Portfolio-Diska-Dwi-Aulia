import './CartBox.css'

const formatRp = (n) => n.toLocaleString('id-ID')

function CartBox({
  customerName,
  customerAddress,
  onNameChange,
  onAddressChange,
  cart,
  total,
  orderType,
  pickupPlate,
  onUpdateQty,
  onConfirmOrder,
  onOpenOrderModal,
}) {
  const totalItems = cart.reduce((s, i) => s + i.qty, 0)

  return (
    <div className="cart-box">
      {/* HEADER */}
      <div className="cart-header">
        <h3 className="cart-title">
          🛒 Keranjang
          {totalItems > 0 && <span className="cart-count">{totalItems}</span>}
        </h3>
        {orderType && (
          <span className={`badge ${orderType === 'delivery' ? 'badge-delivery' : 'badge-takeaway'}`}>
            {orderType === 'delivery' ? '🛵 Delivery' : '🛍️ Takeaway'}
          </span>
        )}
      </div>

      {/* ORDER TYPE MISSING WARNING */}
      {!orderType && (
        <div className="cart-warning">
          <span>⚠️</span>
          <span>Pilih metode pesan dulu di bagian atas!</span>
        </div>
      )}

      {/* CUSTOMER INFO */}
      <div className="cart-info-section">
        <label className="cart-label">Nama Pemesan</label>
        <input
          className="input-field"
          placeholder="Masukkan nama kamu..."
          value={customerName}
          onChange={(e) => onNameChange(e.target.value)}
        />

        {orderType === 'delivery' && (
          <>
            <label className="cart-label" style={{ marginTop: '12px' }}>Alamat Pengiriman</label>
            <textarea
              className="input-field"
              placeholder="Masukkan alamat lengkap..."
              value={customerAddress}
              onChange={(e) => onAddressChange(e.target.value)}
              rows="2"
            />
          </>
        )}

        {orderType === 'takeaway' && pickupPlate && (
          <>
            <label className="cart-label" style={{ marginTop: '12px' }}>No. Plat Kendaraan</label>
            <div className="plate-display">
              🚗 {pickupPlate}
              <button className="plate-edit-btn" onClick={onOpenOrderModal}>Edit</button>
            </div>
          </>
        )}

        {orderType && (
          <button className="btn-change-order" onClick={onOpenOrderModal}>
            ✏️ Ubah Detail Pesanan
          </button>
        )}
      </div>

      <div className="cart-divider" />

      {/* CART ITEMS */}
      <div className="cart-items">
        {cart.length === 0 ? (
          <div className="empty-cart">
            <span className="empty-cart-icon">🍽️</span>
            <p>Belum ada item dipilih</p>
            <span className="empty-hint">Tambahkan dari menu di kiri</span>
          </div>
        ) : (
          cart.map((item) => (
            <div key={item.id} className="cart-item">
              <div className="cart-item-info">
                <div className="cart-item-name">{item.name}</div>
                <div className="cart-item-unit">Rp {formatRp(item.price)} /porsi</div>
              </div>
              <div className="cart-item-right">
                <div className="qty-controls">
                  <button className="qty-btn" onClick={() => onUpdateQty(item.id, -1)}>−</button>
                  <span className="qty-value">{item.qty}</span>
                  <button className="qty-btn qty-btn-plus" onClick={() => onUpdateQty(item.id, 1)}>+</button>
                </div>
                <div className="cart-item-subtotal">Rp {formatRp(item.price * item.qty)}</div>
              </div>
            </div>
          ))
        )}
      </div>

      {/* SUMMARY */}
      {cart.length > 0 && (
        <>
          <div className="cart-divider" />
          <div className="cart-summary">
            <div className="summary-row">
              <span>Subtotal ({totalItems} item)</span>
              <span>Rp {formatRp(total)}</span>
            </div>
            {orderType === 'delivery' && (
              <div className="summary-row">
                <span>Ongkir</span>
                <span className="free-badge">Gratis 🎉</span>
              </div>
            )}
            <div className="summary-total">
              <span>Total Tagihan</span>
              <span className="total-amount">Rp {formatRp(total)}</span>
            </div>
          </div>
        </>
      )}

      <button
        className="btn-confirm-order"
        onClick={onConfirmOrder}
        disabled={cart.length === 0}
      >
        {cart.length === 0 ? 'Keranjang Kosong' : 'KONFIRMASI PESANAN →'}
      </button>
    </div>
  )
}

export default CartBox
