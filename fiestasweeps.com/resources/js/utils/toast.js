// Simple toast implementation
class Toast {
  constructor() {
    this.container = null
    this.createContainer()
  }

  createContainer() {
    if (document.querySelector('.toast-container')) return

    this.container = document.createElement('div')
    this.container.className = 'toast-container position-fixed top-0 end-0 p-3'
    this.container.style.zIndex = '9999'
    document.body.appendChild(this.container)
  }

  show(message, type = 'info', duration = 5000) {
    const toast = document.createElement('div')
    toast.className = `toast show align-items-center text-white bg-${this.getBootstrapType(type)} border-0`
    toast.setAttribute('role', 'alert')

    toast.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">
          ${message}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    `

    this.container.appendChild(toast)

    // Auto remove
    setTimeout(() => {
      if (toast.parentNode) {
        toast.remove()
      }
    }, duration)

    // Add click to close
    const closeBtn = toast.querySelector('.btn-close')
    closeBtn.addEventListener('click', () => {
      if (toast.parentNode) {
        toast.remove()
      }
    })
  }

  getBootstrapType(type) {
    const typeMap = {
      success: 'success',
      error: 'danger',
      warning: 'warning',
      info: 'info'
    }
    return typeMap[type] || 'info'
  }

  success(message) {
    this.show(message, 'success')
  }

  error(message) {
    this.show(message, 'error')
  }

  warning(message) {
    this.show(message, 'warning')
  }

  info(message) {
    this.show(message, 'info')
  }
}

export const toast = new Toast()
