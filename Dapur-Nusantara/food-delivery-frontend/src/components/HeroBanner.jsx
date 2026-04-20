import './HeroBanner.css'

function HeroBanner({ orderType, onSelectOrderType, onOpenOrderModal, customerName }) {
  const scrollToMenu = () => {
    const el = document.getElementById('menu-section')
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' })
    else window.scrollTo({ top: 600, behavior: 'smooth' })
  }

  return (
    <div className="hero-wrapper">
      <section className="hero-banner">
        <div className="hero-content">
          <div className="hero-tag">🔥 Pesan Sekarang, Nikmati Lebih Cepat</div>
          <h1 className="hero-title">
            Cita Rasa <span className="hero-accent">Nusantara</span>
            <br />Siap Antar ke Pintumu
          </h1>
          <p className="hero-sub">
            Pilih cara pesan favoritmu – diantar atau kamu ambil sendiri!
          </p>
          <div className="hero-actions">
            <button
              className={`hero-method-btn ${orderType === 'delivery' ? 'active-delivery' : ''}`}
              onClick={() => { onSelectOrderType('delivery'); scrollToMenu(); }}
            >
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <path d="M1 3h15v13H1zM16 8h4l3 3v5h-7V8z"/>
                <circle cx="5.5" cy="18.5" r="2.5"/>
                <circle cx="18.5" cy="18.5" r="2.5"/>
              </svg>
              <span>Delivery</span>
              {orderType === 'delivery' && <span className="active-dot" />}
            </button>
            <button
              className={`hero-method-btn ${orderType === 'takeaway' ? 'active-takeaway' : ''}`}
              onClick={() => { onSelectOrderType('takeaway'); scrollToMenu(); }}
            >
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 0 1-8 0"/>
              </svg>
              <span>Takeaway</span>
              {orderType === 'takeaway' && <span className="active-dot" />}
            </button>
          </div>
          {orderType && (
            <button className="hero-edit-order" onClick={onOpenOrderModal}>
              ✏️ Ubah Detail Pesanan ({orderType === 'delivery' ? 'Delivery' : 'Takeaway'})
            </button>
          )}
        </div>

        {/* Floating stats */}
        <div className="hero-stats">
          <div className="stat-item">
            <span className="stat-num">50+</span>
            <span className="stat-label">Menu Pilihan</span>
          </div>
          <div className="stat-divider" />
          <div className="stat-item">
            <span className="stat-num">30M</span>
            <span className="stat-label">Pengiriman</span>
          </div>
          <div className="stat-divider" />
          <div className="stat-item">
            <span className="stat-num">4.9⭐</span>
            <span className="stat-label">Rating</span>
          </div>
        </div>
      </section>
    </div>
  )
}

export default HeroBanner
