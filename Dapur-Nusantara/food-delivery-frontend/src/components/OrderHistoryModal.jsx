import './OrderHistoryModal.css'

function OrderHistoryModal({ orders, onClose, menus }) {
  const getMenuName = (menuId) => {
    const menu = menus.find(m => m.id === menuId || m.id?.toString() === menuId?.toString())
    return menu ? menu.name : `Menu #${menuId}`
  }

  const formatDate = (dateVal) => {
    if (!dateVal) return 'Selesai'
    const d = new Date(isNaN(dateVal) ? dateVal : parseInt(dateVal))
    return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })
  }

  const formatRp = (n) => Number(n).toLocaleString('id-ID')

  return (
    <div className="modal-overlay" onClick={onClose}>
      <div className="modal-box history-modal-box" onClick={(e) => e.stopPropagation()}>
        <button className="modal-close-btn" onClick={onClose}>×</button>

        <div className="history-header">
          <h2 className="modal-title">📋 Riwayat Pesanan</h2>
          {orders.length > 0 && (
            <span className="history-count">{orders.length} pesanan</span>
          )}
        </div>

        {orders && orders.length > 0 ? (
          <div className="history-list">
            {orders.map((order, idx) => (
              <div key={idx} className="history-item">
                <div className="history-item-top">
                  <div className="history-order-id" style={{ color: '#ff8c42', fontWeight: 'bold' }}>
                    #{order.order_id || order.id || (idx + 1)}
                  </div>
                  <span className={`badge ${order.order_type === 'takeaway' ? 'badge-takeaway' : 'badge-delivery'}`} style={{ fontSize: '10px' }}>
                    {order.order_type === 'takeaway' ? '🛍️ TAKEAWAY' : '🛵 DELIVERY'}
                  </span>
                </div>

                <div className="history-item-body">
                  <div className="history-detail-row">
                    <span className="history-detail-label">Menu</span>
                    <span className="history-detail-value">
                      {order.menu?.name || getMenuName(order.menu_id)}
                    </span>
                  </div>
                  <div className="history-detail-row">
                    <span className="history-detail-label">Jumlah</span>
                    <span className="history-detail-value">{order.qty} porsi</span>
                  </div>
                  <div className="history-detail-row">
                    <span className="history-detail-label">Tanggal</span>
                    <span className="history-detail-value">{formatDate(order.order_date)}</span>
                  </div>
                  {order.order_type === 'takeaway' && order.pickup_number && (
                    <div className="history-detail-row">
                      <span className="history-detail-label">No. Ambil</span>
                      <span className="history-detail-value pickup-val">
                        🚗 {order.pickup_number}
                      </span>
                    </div>
                  )}
                  {order.total && (
                    <div className="history-total-row">
                      <span>Total</span>
                      <span className="history-total-amount">Rp {formatRp(order.total)}</span>
                    </div>
                  )}
                </div>
              </div>
            ))}
          </div>
        ) : (
          <div className="history-empty">
            <div className="history-empty-icon">📭</div>
            <p>Belum ada riwayat pesanan.</p>
            <span>Yuk mulai pesan sekarang!</span>
          </div>
        )}

        <button className="btn-primary history-close-btn" onClick={onClose}>
          Tutup
        </button>
      </div>
    </div>
  )
}

export default OrderHistoryModal
