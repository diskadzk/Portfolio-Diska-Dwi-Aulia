import './OrderTypeModal.css'
import { useState, useEffect } from 'react'

function OrderTypeModal({ initialType, onClose, onConfirm, savedAddress, savedPlate }) {
  const [type, setType] = useState(initialType || 'delivery')
  const [address, setAddress] = useState(savedAddress || '')
  const [plate, setPlate] = useState(savedPlate || '')
  const [deliveryTime, setDeliveryTime] = useState('now')

  useEffect(() => {
    if (initialType) setType(initialType)
  }, [initialType])

  const handleConfirm = () => {
    if (type === 'delivery' && !address.trim()) {
      alert('Tolong isi alamat pengiriman!')
      return
    }
    if (type === 'takeaway' && !plate.trim()) {
      alert('Tolong isi nomor plat kendaraan untuk pickup!')
      return
    }
    onConfirm({ type, address: address.trim(), plate: plate.trim(), deliveryTime })
  }

  const isValid = type === 'delivery' ? address.trim().length > 0 : plate.trim().length > 0

  return (
    <div className="modal-overlay" onClick={onClose}>
      <div className="modal-box order-type-modal-box" onClick={(e) => e.stopPropagation()}>
        <button className="modal-close-btn" onClick={onClose}>×</button>
        
        <div className="otm-header">
          <div className="otm-icon">
            {type === 'delivery' ? '🛵' : '🛍️'}
          </div>
          <h2 className="modal-title">Detail Pesanan</h2>
          <p className="otm-subtitle">Lengkapi informasi di bawah untuk melanjutkan</p>
        </div>

        {/* TYPE TOGGLE */}
        <div className="otm-toggle">
          <button
            className={`otm-toggle-btn ${type === 'delivery' ? 'active' : ''}`}
            onClick={() => setType('delivery')}
          >
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
              <path d="M1 3h15v13H1zM16 8h4l3 3v5h-7V8z"/>
              <circle cx="5.5" cy="18.5" r="2.5"/>
              <circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>
            Delivery
          </button>
          <button
            className={`otm-toggle-btn ${type === 'takeaway' ? 'active-takeaway' : ''}`}
            onClick={() => setType('takeaway')}
          >
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
              <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
              <line x1="3" y1="6" x2="21" y2="6"/>
              <path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            Takeaway
          </button>
        </div>

        {/* FORM */}
        <div className="otm-form">
          {type === 'delivery' ? (
            <>
              <div className="form-group">
                <label>Alamat Pengiriman <span className="req">*</span></label>
                <textarea
                  className="input-field"
                  placeholder="Contoh: Jl. Sudirman No. 10, RT 03/RW 04, Bandung..."
                  value={address}
                  onChange={(e) => setAddress(e.target.value)}
                  rows="3"
                />
              </div>
              <div className="form-group">
                <label>Waktu Pengiriman</label>
                <select
                  className="input-field"
                  value={deliveryTime}
                  onChange={(e) => setDeliveryTime(e.target.value)}
                >
                  <option value="now">Sekarang (~30 menit)</option>
                  <option value="later">Nanti / Jadwalkan</option>
                </select>
              </div>
              <div className="otm-info-box">
                <span>🎉</span>
                <span>Ongkos kirim <strong>GRATIS</strong> untuk semua wilayah!</span>
              </div>
            </>
          ) : (
            <>
              <div className="form-group">
                <label>Waktu Pengambilan</label>
                <select
                  className="input-field"
                  value={deliveryTime}
                  onChange={(e) => setDeliveryTime(e.target.value)}
                >
                  <option value="now">Sekarang (~15 menit)</option>
                  <option value="later">Nanti / Jadwalkan</option>
                </select>
              </div>
              <div className="form-group">
                <label>No. Plat Kendaraan <span className="req">*</span></label>
                <input
                  className="input-field"
                  type="text"
                  placeholder="Contoh: D 1234 ABC"
                  value={plate}
                  onChange={(e) => setPlate(e.target.value.toUpperCase())}
                />
              </div>
              <div className="otm-info-box otm-info-takeaway">
                <span>🚗</span>
                <span>Tim kami akan langsung mengantar ke kendaraanmu di area pickup!</span>
              </div>
            </>
          )}
        </div>

        {/* ACTIONS */}
        <div className="otm-actions">
          <button className="btn-outline" onClick={onClose}>Batal</button>
          <button
            className={`btn-primary ${!isValid ? 'disabled-btn' : ''}`}
            onClick={handleConfirm}
            style={{ flex: 1 }}
          >
            Konfirmasi Detail ✓
          </button>
        </div>
      </div>
    </div>
  )
}

export default OrderTypeModal
