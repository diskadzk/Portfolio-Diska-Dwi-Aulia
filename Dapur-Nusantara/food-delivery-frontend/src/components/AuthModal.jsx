import { useState } from 'react'

function AuthModal({ mode, onClose, onLogin, onSignup }) {
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [name, setName] = useState('')
  const [address, setAddress] = useState('')
  const [showPass, setShowPass] = useState(false)

  const handleSubmit = (e) => {
    e.preventDefault()

    if (!email || !password) {
      alert('Email & Password wajib diisi!')
      return
    }

    if (mode === 'login') {
      onLogin(email, password)
    } else {
      if (!name) {
        alert('Nama wajib diisi!')
        return
      }
      onSignup(name, email, password, address)
    }

    setEmail(''); setPassword(''); setName(''); setAddress('')
  }

  return (
    <div className="modal-overlay" onClick={onClose}>
      <div className="modal-box auth-modal-box" onClick={(e) => e.stopPropagation()}>
        <button className="modal-close-btn" onClick={onClose}>×</button>

        <div className="auth-modal-header">
          <div className="auth-modal-logo">🍜</div>
          <h2 className="modal-title">
            {mode === 'login' ? 'Selamat Datang!' : 'Buat Akun Baru'}
          </h2>
          <p className="auth-modal-sub">
            {mode === 'login'
              ? 'Masuk untuk melanjutkan pesananmu'
              : 'Daftar sekarang dan nikmati kelezatan Nusantara'}
          </p>
        </div>

        <form onSubmit={handleSubmit} className="auth-form">
          {mode === 'signup' && (
            <div className="form-group">
              <label>Nama Lengkap <span className="req">*</span></label>
              <input
                className="input-field"
                placeholder="Nama kamu..."
                value={name}
                onChange={(e) => setName(e.target.value)}
                required
              />
            </div>
          )}

          <div className="form-group">
            <label>Email <span className="req">*</span></label>
            <input
              className="input-field"
              type="email"
              placeholder="email@kamu.com"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </div>

          <div className="form-group">
            <label>Password <span className="req">*</span></label>
            <div className="input-password-wrapper">
              <input
                className="input-field"
                type={showPass ? 'text' : 'password'}
                placeholder="••••••••"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
                style={{ paddingRight: '48px' }}
              />
              <button
                type="button"
                className="pass-toggle"
                onClick={() => setShowPass(!showPass)}
              >
                {showPass ? '🙈' : '👁️'}
              </button>
            </div>
          </div>

          {mode === 'signup' && (
            <div className="form-group">
              <label>Alamat Lengkap <span className="text-opt">(opsional)</span></label>
              <input
                className="input-field"
                placeholder="Jl. Merdeka No. 1, Bandung..."
                value={address}
                onChange={(e) => setAddress(e.target.value)}
              />
            </div>
          )}

          <button type="submit" className="btn-primary auth-submit-btn">
            {mode === 'login' ? 'Masuk →' : 'Buat Akun →'}
          </button>
        </form>

        <p className="auth-modal-footer">
          {mode === 'login' ? 'Belum punya akun?' : 'Sudah punya akun?'}
          {' '}
          <span className="auth-switch-link" onClick={onClose}>
            {mode === 'login' ? 'Daftar sekarang' : 'Login di sini'}
          </span>
        </p>
      </div>
    </div>
  )
}

export default AuthModal
