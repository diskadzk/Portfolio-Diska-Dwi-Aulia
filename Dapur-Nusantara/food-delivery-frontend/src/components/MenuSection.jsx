import './MenuSection.css'

const formatRp = (n) => n.toLocaleString('id-ID')

function MenuSection({ menus, imageBaseUrl, onAddToCart, cartIds = [] }) {
  return (
    <div className="menu-grid" id="menu-section">
      {menus.length === 0 ? (
        <div className="empty-menu">
          <div className="empty-menu-icon">🍽️</div>
          <p>Gagal memuat menu. Silakan refresh halaman.</p>
        </div>
      ) : (
        menus.map((menu) => {
          const inCart = cartIds.includes(menu.id)
          return (
            <div key={menu.id} className={`menu-card ${inCart ? 'in-cart' : ''}`}>
              <div className="menu-card-img-wrapper">
                <img
                  src={`${imageBaseUrl}/${menu.image}`}
                  alt={menu.name}
                  className="menu-card-img"
                  onError={(e) => {
                    e.target.src = 'https://images.unsplash.com/photo-1546241072-48010ad28c2c?w=500'
                  }}
                />
                {inCart && (
                  <div className="in-cart-badge">✓ Di Keranjang</div>
                )}
              </div>
              <div className="menu-card-body">
                <h3 className="menu-card-name">{menu.name}</h3>
                <div className="menu-card-footer">
                  <span className="menu-card-price">Rp {formatRp(menu.price)}</span>
                  <button
                    className="btn-add-cart"
                    onClick={() => onAddToCart(menu)}
                  >
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5">
                      <line x1="12" y1="5" x2="12" y2="19" />
                      <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah
                  </button>
                </div>
              </div>
            </div>
          )
        })
      )}
    </div>
  )
}

export default MenuSection
