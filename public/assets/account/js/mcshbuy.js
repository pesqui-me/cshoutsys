/**
 * CASH OUT - mcshbuy.js
 * JavaScript pour l'espace utilisateur
 */

$(document).ready(function() {
    
    // ============================================
    // Menu Mobile Toggle (géré par Alpine.js maintenant)
    // ============================================
    
    // Fermer le menu quand on clique sur un lien (mobile)
    $('.menu-item').on('click', function() {
        if (window.innerWidth <= 768) {
            // Déclencher Alpine.js pour fermer
            document.querySelector('[x-data]').__x.$data.sidebarOpen = false;
        }
    });
    
    // ============================================
    // Menu actif selon la route
    // ============================================
    
    const currentPath = window.location.pathname;
    $('.menu-item').removeClass('active');
    
    $('.menu-item').each(function() {
        const href = $(this).attr('href');
        if (href && currentPath.includes(href.split('/').pop())) {
            $(this).addClass('active');
        }
    });
    
    // ============================================
    // Notifications Dropdown
    // ============================================
    
    $('.notification-btn').on('click', function(e) {
        e.stopPropagation();
        // Toggle via Alpine.js
        const alpineData = document.querySelector('[x-data]').__x.$data;
        alpineData.notificationsOpen = !alpineData.notificationsOpen;
    });
    
    // Fermer notifications si clic ailleurs
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.notification-btn, .notifications-dropdown').length) {
            const alpineData = document.querySelector('[x-data]').__x.$data;
            if (alpineData) {
                alpineData.notificationsOpen = false;
            }
        }
    });
    
    // ============================================
    // Profile Menu
    // ============================================
    
    // $('.user-menu').on('click', function() {
    //     window.location.href = '/user/profile';
    // });
    
    // ============================================
    // Copy to Clipboard (pour code parrainage)
    // ============================================
    
    window.copyToClipboard = function(text, message = 'Copié !') {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(function() {
                showToast(message, 'success');
            }).catch(function(err) {
                console.error('Erreur copie:', err);
                fallbackCopy(text);
            });
        } else {
            fallbackCopy(text);
        }
    };
    
    // Fallback pour anciens navigateurs
    function fallbackCopy(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        
        try {
            document.execCommand('copy');
            showToast('Copié !', 'success');
        } catch (err) {
            console.error('Erreur copie:', err);
            showToast('Erreur lors de la copie', 'error');
        }
        
        document.body.removeChild(textarea);
    }
    
    // ============================================
    // Toast Notifications
    // ============================================
    
    window.showToast = function(message, type = 'info') {
        const toast = $(`
            <div class="toast toast-${type}" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                z-index: 10000;
                animation: slideInRight 0.3s ease-out;
            ">
                ${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'} ${message}
            </div>
        `);
        
        $('body').append(toast);
        
        setTimeout(function() {
            toast.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    };
    
    // ============================================
    // Confirmation de déconnexion
    // ============================================
    
    $('.logout-btn').on('click', function(e) {
        if (!confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
            e.preventDefault();
            return false;
        }
    });
    
    // ============================================
    // Format Numbers
    // ============================================
    
    window.formatMoney = function(amount) {
        return new Intl.NumberFormat('fr-FR', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        }).format(amount);
    };
    
    // ============================================
    // Responsive Tables
    // ============================================
    
    function makeTablesResponsive() {
        $('.transactions-table, table').each(function() {
            if (!$(this).parent().hasClass('table-responsive')) {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });
    }
    
    makeTablesResponsive();
    
    // ============================================
    // Animations
    // ============================================
    
    // Ajouter les animations CSS
    if (!$('#custom-animations').length) {
        $('head').append(`
            <style id="custom-animations">
                @keyframes slideInRight {
                    from {
                        opacity: 0;
                        transform: translateX(100px);
                    }
                    to {
                        opacity: 1;
                        transform: translateX(0);
                    }
                }
                
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
                
                .sidebar-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.5);
                    z-index: 998;
                }
                
                @media (max-width: 768px) {
                    body.sidebar-open {
                        overflow: hidden;
                    }
                }
            </style>
        `);
    }
    
    // ============================================
    // Console Info
    // ============================================
    
    console.log('%c💎 CASH OUT', 'color: #8b5cf6; font-size: 20px; font-weight: bold;');
    console.log('%cInterface utilisateur chargée avec succès!', 'color: #10b981;');
    
});