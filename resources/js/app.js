import 'bootstrap';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

window.Swal = Swal;
window.Chart = Chart;

/* =========================================================
   SWEETALERT — TEMA EDITORIAL (selaras landing page)
   ========================================================= */

const DKTheme = {
    primary:      '#E36A2E',   // oranye aksen landing page
    primaryHover: '#c85a24',
    text:         '#1A1A1A',
    muted:        '#6B6B6B',
    border:       '#e0d5cb',
    bg:           '#ffffff',
    success:      '#26966F',
    danger:       '#DC5252',
    fontBody:     "'Inter', system-ui, -apple-system, sans-serif",
    fontHead:     "'Playfair Display', Georgia, serif",
};

/* --- Inject CSS tema sekali saja --- */
(function injectSwalTheme() {
    if (document.getElementById('dk-swal-theme')) return;
    const style = document.createElement('style');
    style.id = 'dk-swal-theme';
    style.textContent = `
        /* ============ POPUP KONFIRMASI ============ */
        .swal2-popup.dk-swal {
            font-family: ${DKTheme.fontBody};
            border-radius: 16px;
            border: 1px solid ${DKTheme.border};
            box-shadow: 0 30px 80px rgba(48, 37, 31, 0.15);
            padding: 2rem 1.75rem 1.5rem;
            background: ${DKTheme.bg};
        }

        /* Label editorial kecil di atas judul (KONFIRMASI / HAPUS DATA / dll) */
        .swal2-popup.dk-swal .dk-swal-label {
            display: block;
            font-family: ${DKTheme.fontBody};
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: ${DKTheme.primary};
            text-align: center;
            margin-bottom: 0.6rem;
        }

        .swal2-popup.dk-swal .swal2-title {
            font-family: ${DKTheme.fontHead};
            font-size: 1.5rem;
            font-weight: 700;
            color: ${DKTheme.text};
            padding: 0 0 0.75rem;
            line-height: 1.25;
        }

        .swal2-popup.dk-swal .swal2-html-container {
            color: ${DKTheme.muted};
            font-family: ${DKTheme.fontBody};
            font-size: 0.95rem;
            line-height: 1.7;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Sembunyikan ikon besar — ganti label editorial */
        .swal2-popup.dk-swal .swal2-icon {
            display: none !important;
        }

        .swal2-popup.dk-swal .swal2-actions {
            gap: 0.5rem;
            margin-top: 1.75rem;
        }

        .swal2-popup.dk-swal .swal2-confirm,
        .swal2-popup.dk-swal .swal2-cancel {
            border-radius: 50px;
            font-family: ${DKTheme.fontBody};
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.7rem 1.75rem;
            border: none;
            box-shadow: none !important;
            transition: transform .2s, background .2s, color .2s, border-color .2s;
        }

        /* Tombol utama (oranye) */
        .swal2-popup.dk-swal .swal2-confirm {
            background-color: ${DKTheme.primary} !important;
            color: #fff !important;
        }
        .swal2-popup.dk-swal .swal2-confirm:hover {
            background-color: ${DKTheme.primaryHover} !important;
            transform: translateY(-1px);
        }
        .swal2-popup.dk-swal .swal2-confirm:focus {
            box-shadow: 0 0 0 3px rgba(227, 106, 46, 0.2) !important;
        }

        /* Tombol batal (teks minimalis) */
        .swal2-popup.dk-swal .swal2-cancel {
            background-color: transparent !important;
            color: ${DKTheme.muted} !important;
            border: 1px solid transparent !important;
        }
        .swal2-popup.dk-swal .swal2-cancel:hover {
            color: ${DKTheme.text} !important;
            border-color: ${DKTheme.border} !important;
        }

        /* Varian danger (hapus) — tetap oranye? tidak, merah lembut */
        .swal2-popup.dk-swal-danger .swal2-confirm {
            background-color: ${DKTheme.danger} !important;
        }
        .swal2-popup.dk-swal-danger .swal2-confirm:hover {
            background-color: #b93e3e !important;
        }
        .swal2-popup.dk-swal-danger .swal2-confirm:focus {
            box-shadow: 0 0 0 3px rgba(220, 82, 82, 0.2) !important;
        }
        .swal2-popup.dk-swal-danger .dk-swal-label {
            color: ${DKTheme.danger};
        }

        /* ============ TOAST (pojok kanan atas) ============ */
        .swal2-popup.dk-toast {
            font-family: ${DKTheme.fontBody};
            border-radius: 12px;
            border: 1px solid ${DKTheme.border};
            box-shadow: 0 20px 50px rgba(48, 37, 31, 0.12);
            padding: 0.85rem 1.15rem;
            background: ${DKTheme.bg};
        }
        .swal2-popup.dk-toast .swal2-title {
            font-family: ${DKTheme.fontBody};
            font-size: 0.9rem;
            font-weight: 600;
            color: ${DKTheme.text};
            padding: 0;
            line-height: 1.4;
        }
        .swal2-popup.dk-toast .swal2-icon {
            width: 1.75rem !important;
            height: 1.75rem !important;
            margin: 0 0.75rem 0 0 !important;
            border-width: 2px !important;
            display: inline-flex !important;
        }
        .swal2-popup.dk-toast .swal2-icon .swal2-icon-content {
            font-size: 1.05rem !important;
        }
        .swal2-popup.dk-toast .swal2-timer-progress-bar {
            background: ${DKTheme.primary};
        }
        .swal2-container.swal2-top-end {
            padding: 1rem;
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 576px) {
            .swal2-popup.dk-swal {
                padding: 1.5rem 1.25rem 1.25rem;
                border-radius: 14px;
            }
            .swal2-popup.dk-swal .swal2-title {
                font-size: 1.3rem;
            }
            .swal2-popup.dk-swal .swal2-actions {
                flex-direction: column-reverse;
                width: 100%;
            }
            .swal2-popup.dk-swal .swal2-confirm,
            .swal2-popup.dk-swal .swal2-cancel {
                width: 100%;
                margin: 0;
            }
        }
    `;
    document.head.appendChild(style);
})();

/* --- Helper: Label editorial di atas judul --- */
function injectLabel(popup, text, color) {
    if (!text) return;
    if (popup.querySelector('.dk-swal-label')) return;
    const titleEl = popup.querySelector('.swal2-title');
    if (!titleEl) return;
    const lbl = document.createElement('div');
    lbl.className = 'dk-swal-label';
    lbl.textContent = text;
    if (color) lbl.style.color = color;
    titleEl.parentNode.insertBefore(lbl, titleEl);
}

/* --- Helper: Toast --- */
window.dkToast = function (icon, title) {
    return Swal.fire({
        toast: true,
        position: 'top-end',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        customClass: { popup: 'dk-toast' },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
    });
};

/* --- Helper: Konfirmasi Hapus --- */
window.dkConfirmDelete = function (options = {}) {
    const {
        title = 'Hapus data ini?',
        text = 'Tindakan ini tidak dapat dibatalkan.',
        label = 'KONFIRMASI HAPUS',
        confirmText = 'Ya, Hapus',
        cancelText = 'Batal',
        form = null,
        url = null,
    } = options;

    return Swal.fire({
        title: title,
        html: text,
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        reverseButtons: true,
        focusCancel: true,
        customClass: {
            popup: 'dk-swal dk-swal-danger',
            confirmButton: 'swal2-confirm',
            cancelButton: 'swal2-cancel',
        },
        didOpen: (popup) => {
            injectLabel(popup, label, DKTheme.danger);
        },
    }).then((result) => {
        if (!result.isConfirmed) return false;
        if (form) { form.submit(); return true; }
        if (url) {
            const f = document.createElement('form');
            f.method = 'POST';
            f.action = url;
            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            f.innerHTML = `<input type="hidden" name="_token" value="${csrf}"><input type="hidden" name="_method" value="DELETE">`;
            document.body.appendChild(f);
            f.submit();
            return true;
        }
        return true;
    });
};

/* --- Helper: Konfirmasi generik (non-delete) --- */
window.dkConfirm = function (options = {}) {
    const {
        title = 'Lanjutkan?',
        text = '',
        label = 'KONFIRMASI',
        confirmText = 'Ya, Lanjutkan',
        cancelText = 'Batal',
        danger = false,
        onConfirm = null,
    } = options;

    return Swal.fire({
        title: title,
        html: text,
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        reverseButtons: true,
        focusCancel: true,
        customClass: {
            popup: 'dk-swal ' + (danger ? 'dk-swal-danger' : ''),
            confirmButton: 'swal2-confirm',
            cancelButton: 'swal2-cancel',
        },
        didOpen: (popup) => {
            injectLabel(popup, label, danger ? DKTheme.danger : DKTheme.primary);
        },
    }).then((result) => {
        if (result.isConfirmed && typeof onConfirm === 'function') onConfirm();
        return result.isConfirmed;
    });
};

/* =========================================================
   DOM READY — Auto-bind & init
   ========================================================= */
document.addEventListener('DOMContentLoaded', function () {

    /* 1. Auto-bind semua [data-confirm] → SweetAlert */
    document.querySelectorAll('[data-confirm]').forEach((el) => {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            const form = el.closest('form');
            const title = el.getAttribute('data-confirm-title') || 'Hapus data ini?';
            const msg = el.getAttribute('data-confirm') || 'Tindakan ini tidak dapat dibatalkan.';
            const label = el.getAttribute('data-confirm-label') || 'KONFIRMASI HAPUS';
            dkConfirmDelete({ title, text: msg, label, form });
        });
    });

    /* 2. Flash session → Toast */
    const flashSuccess = document.querySelector('[data-flash-success]');
    const flashError = document.querySelector('[data-flash-error]');
    if (flashSuccess) dkToast('success', flashSuccess.getAttribute('data-flash-success'));
    if (flashError)   dkToast('error',   flashError.getAttribute('data-flash-error'));

    /* 3. Fallback: alert lama auto-dismiss */
    document.querySelectorAll('.alert-auto-dismiss').forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity .5s';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 500);
        }, 4000);
    });

    /* 4. Navbar Auto-Hide on Scroll */
    let lastScrollTop = 0;
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
            if (scrollTop > lastScrollTop && scrollTop > 200) navbar.classList.add('hide-nav');
            else navbar.classList.remove('hide-nav');
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
    }
});