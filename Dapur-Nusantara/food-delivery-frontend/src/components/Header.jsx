import './Header.css'

function Header({ currentUser, onLoginClick, onSignupClick, onLogout, onHistoryClick }) {
  return (
    <header className="header">
      <div className="header-inner">
        <div className="logo-area">
          <div className="logo-icon">🍜</div>
          <div className="logo-text">
            <span className="logo-main">DAPUR</span>
            <span className="logo-sub">POCOLOCO</span>
          </div>
        </div>

        <nav className="header-nav">
          {currentUser ? (
            <div className="user-area">
              <div className="user-avatar">
                {currentUser.name?.charAt(0).toUpperCase()}
              </div>
              <span className="user-greeting">
                Halo, <strong>{currentUser.name}</strong>
              </span>
              <button className="nav-btn nav-btn-ghost" onClick={onHistoryClick}>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                  <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                Riwayat
              </button>
              <button className="nav-btn nav-btn-outline" onClick={onLogout}>
                Logout
              </button>
            </div>
          ) : (
            <div className="auth-area">
              <button className="nav-btn nav-btn-ghost" onClick={onLoginClick}>
                Login
              </button>
              <button className="nav-btn nav-btn-primary" onClick={onSignupClick}>
                Daftar
              </button>
            </div>
          )}
        </nav>
      </div>
    </header>
  )
}

export default Header
