<x-admin-layout>
    <!-- Main Content -->
    <main class="main-content">
        <header class="header">
            <div class="header-left">
                <button class="menu-toggle" id="menuToggle">☰</button>
                <h1 class="header-title">Gestion des Utilisateurs</h1>
            </div>
            <div class="header-right">
                <button class="notification-btn">
                    🔔
                    <span class="notification-badge">28</span>
                </button>
                <div class="user-menu">
                    <div class="user-avatar">AD</div>
                </div>
            </div>
        </header>

        <div class="page-content">
            <!-- Filters -->
            <div class="filters-section">
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">Rechercher</label>
                        <input type="text" class="search-input" id="searchUsers" placeholder="Nom, email...">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Statut</label>
                        <select class="filter-select" id="filterStatus">
                            <option value="all">Tous les statuts</option>
                            <option value="active">Actifs</option>
                            <option value="suspended">Suspendus</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Pays</label>
                        <select class="filter-select" id="filterCountry">
                            <option value="all">Tous les pays</option>
                            <option value="BJ">Bénin</option>
                            <option value="FR">France</option>
                            <option value="CI">Côte d'Ivoire</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Période</label>
                        <select class="filter-select" id="filterPeriod">
                            <option value="all">Toute la période</option>
                            <option value="today">Aujourd'hui</option>
                            <option value="week">Cette semaine</option>
                            <option value="month">Ce mois</option>
                        </select>
                    </div>
                </div>
                <div class="filter-buttons">
                    <button class="btn btn-primary" id="applyFilters">Appliquer</button>
                    <button class="btn btn-secondary" id="resetFilters">Réinitialiser</button>
                    <button class="btn btn-export">📥 Exporter CSV</button>
                </div>
            </div>

            <!-- Users Table -->
            <div class="users-container">
                <div class="table-header">
                    <h3 class="table-title">Tous les utilisateurs (248)</h3>
                </div>

                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Utilisateur</th>
                            <th>Pays</th>
                            <th>Date d'inscription</th>
                            <th>Solde</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <tr data-user-id="1" data-status="active">
                            <td>#001</td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar-small">JD</div>
                                    <div class="user-details">
                                        <h4>John Doe</h4>
                                        <p>john.doe@email.com</p>
                                    </div>
                                </div>
                            </td>
                            <td>🇧🇯 Bénin</td>
                            <td>10 Nov 2025</td>
                            <td><strong>18.500 $</strong></td>
                            <td><span class="status-badge status-active">✓ Actif</span></td>
                            <td>
                                <button class="actions-btn view-user-btn">Voir détails</button>
                            </td>
                        </tr>
                        <tr data-user-id="2" data-status="active">
                            <td>#002</td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar-small">MM</div>
                                    <div class="user-details">
                                        <h4>Marie Martin</h4>
                                        <p>marie.m@email.com</p>
                                    </div>
                                </div>
                            </td>
                            <td>🇫🇷 France</td>
                            <td>08 Nov 2025</td>
                            <td><strong>25.000 $</strong></td>
                            <td><span class="status-badge status-active">✓ Actif</span></td>
                            <td>
                                <button class="actions-btn view-user-btn">Voir détails</button>
                            </td>
                        </tr>
                        <tr data-user-id="3" data-status="suspended">
                            <td>#003</td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar-small">PD</div>
                                    <div class="user-details">
                                        <h4>Pierre Dubois</h4>
                                        <p>pierre.d@email.com</p>
                                    </div>
                                </div>
                            </td>
                            <td>🇧🇯 Bénin</td>
                            <td>05 Nov 2025</td>
                            <td><strong>0 $</strong></td>
                            <td><span class="status-badge status-suspended">✕ Suspendu</span></td>
                            <td>
                                <button class="actions-btn view-user-btn">Voir détails</button>
                            </td>
                        </tr>
                        <tr data-user-id="4" data-status="active">
                            <td>#004</td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar-small">SB</div>
                                    <div class="user-details">
                                        <h4>Sophie Bernard</h4>
                                        <p>sophie.b@email.com</p>
                                    </div>
                                </div>
                            </td>
                            <td>🇨🇮 Côte d'Ivoire</td>
                            <td>03 Nov 2025</td>
                            <td><strong>12.000 $</strong></td>
                            <td><span class="status-badge status-active">✓ Actif</span></td>
                            <td>
                                <button class="actions-btn view-user-btn">Voir détails</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- User Details Modal -->
    <div class="modal" id="userDetailsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>👤 Détails de l'utilisateur</h3>
                <button class="modal-close" id="closeModal">×</button>
            </div>
            <div class="modal-body">
                <div class="user-detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">ID Utilisateur</span>
                        <span class="detail-value" id="modalUserId">#001</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Nom complet</span>
                        <span class="detail-value" id="modalUserName">John Doe</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Email</span>
                        <span class="detail-value" id="modalUserEmail">john.doe@email.com</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Téléphone</span>
                        <span class="detail-value">+1234567890</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Pays</span>
                        <span class="detail-value">🇧🇯 Bénin</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date d'inscription</span>
                        <span class="detail-value">10 Nov 2025</span>
                    </div>
                </div>

                <div class="stats-grid-modal">
                    <div class="stat-item-modal">
                        <span class="value" style="color: var(--accent);">18.500 $</span>
                        <span class="label">Solde actuel</span>
                    </div>
                    <div class="stat-item-modal">
                        <span class="value" style="color: var(--primary);">3</span>
                        <span class="label">Cartes actives</span>
                    </div>
                    <div class="stat-item-modal">
                        <span class="value" style="color: var(--secondary);">24</span>
                        <span class="label">Transactions</span>
                    </div>
                </div>

                <div style="background: var(--light); padding: 15px; border-radius: 8px; margin: 20px 0;">
                    <h4 style="margin-bottom: 10px;">📝 Notes admin</h4>
                    <textarea style="width: 100%; min-height: 80px; padding: 10px; border: 2px solid #e5e7eb; border-radius: 8px; resize: vertical;" placeholder="Ajouter des notes sur cet utilisateur..."></textarea>
                </div>

                <div class="modal-actions">
                    <button class="btn-action btn-view-details">📊 Historique</button>
                    <button class="btn-action btn-suspend">⏸️ Suspendre</button>
                    <button class="btn-action btn-delete">🗑️ Supprimer</button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>