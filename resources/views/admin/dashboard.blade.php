<x-admin-layout>
    <!-- Main Content -->
    <main class="main-content">
        <header class="header">
            <div class="header-left">
                <button class="menu-toggle" id="menuToggle">☰</button>
                <h1 class="header-title">Vue d'ensemble</h1>
            </div>
            <div class="header-right">
                <button class="notification-btn">
                    🔔
                    <span class="notification-badge">25</span>
                </button>
                <div class="admin-user-menu">
                    <div class="admin-avatar">A</div>
                    <div>
                        <div class="admin-name">Admin</div>
                        <div class="admin-role">Administrateur</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="page-content">
            <!-- Alerts Grid -->
            <div class="alerts-grid">
                <div class="alert-card danger" onclick="window.location.href='purchases.html'">
                    <div class="alert-card-icon">⚠️</div>
                    <div class="alert-card-content">
                        <h4>8 paiements en attente</h4>
                        <p>Validez les nouveaux achats</p>
                    </div>
                </div>

                <div class="alert-card warning" onclick="window.location.href='withdrawals.html'">
                    <div class="alert-card-icon">💰</div>
                    <div class="alert-card-content">
                        <h4>12 retraits à traiter</h4>
                        <p>Approuvez ou rejetez les demandes</p>
                    </div>
                </div>

                <div class="alert-card info" onclick="window.location.href='support.html'">
                    <div class="alert-card-icon">📧</div>
                    <div class="alert-card-content">
                        <h4>5 tickets support</h4>
                        <p>Répondez aux utilisateurs</p>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card primary">
                    <div class="stat-header">
                        <span class="stat-label">Total Utilisateurs</span>
                        <span class="stat-icon">👥</span>
                    </div>
                    <div class="stat-value">124</div>
                    <div class="stat-change positive">
                        ↑ +12 ce mois
                    </div>
                </div>

                <div class="stat-card success">
                    <div class="stat-header">
                        <span class="stat-label">Revenus Total</span>
                        <span class="stat-icon">💰</span>
                    </div>
                    <div class="stat-value">$186,450</div>
                    <div class="stat-change positive">
                        ↑ +8.5% ce mois
                    </div>
                </div>

                <div class="stat-card warning">
                    <div class="stat-header">
                        <span class="stat-label">Cartes Actives</span>
                        <span class="stat-icon">💳</span>
                    </div>
                    <div class="stat-value">89</div>
                    <div class="stat-change positive">
                        ↑ +15 cette semaine
                    </div>
                </div>

                <div class="stat-card danger">
                    <div class="stat-header">
                        <span class="stat-label">Retraits en attente</span>
                        <span class="stat-icon">⏳</span>
                    </div>
                    <div class="stat-value">$45,200</div>
                    <div class="stat-change">
                        12 demandes
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="charts-section">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Revenus des 7 derniers jours</h3>
                        <p class="chart-subtitle">Évolution quotidienne</p>
                    </div>
                    <canvas id="revenueChart" height="80"></canvas>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Répartition par plan</h3>
                        <p class="chart-subtitle">Cartes vendues</p>
                    </div>
                    <canvas id="plansChart"></canvas>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="activity-section">
                <div class="activity-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Activité récente</h3>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon user">👤</div>
                        <div class="activity-details">
                            <h4>Nouvel utilisateur</h4>
                            <p>John Doe s'est inscrit</p>
                        </div>
                        <div class="activity-time">Il y a 5 min</div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon purchase">💳</div>
                        <div class="activity-details">
                            <h4>Achat de carte</h4>
                            <p>Marie L. - Carte 1000$</p>
                        </div>
                        <div class="activity-time">Il y a 12 min</div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon withdrawal">💰</div>
                        <div class="activity-details">
                            <h4>Demande de retrait</h4>
                            <p>Paul M. - 8.500$</p>
                        </div>
                        <div class="activity-time">Il y a 25 min</div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon purchase">💳</div>
                        <div class="activity-details">
                            <h4>Gains crédités</h4>
                            <p>Sophie D. - 30.000$</p>
                        </div>
                        <div class="activity-time">Il y a 1h</div>
                    </div>
                </div>

                <div class="activity-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Top 5 investisseurs</h3>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon user">🥇</div>
                        <div class="activity-details">
                            <h4>Pierre Martin</h4>
                            <p>8 cartes actives</p>
                        </div>
                        <div class="activity-time">$12,000</div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon user">🥈</div>
                        <div class="activity-details">
                            <h4>Marie Dupont</h4>
                            <p>6 cartes actives</p>
                        </div>
                        <div class="activity-time">$9,000</div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon user">🥉</div>
                        <div class="activity-details">
                            <h4>Jean Lambert</h4>
                            <p>5 cartes actives</p>
                        </div>
                        <div class="activity-time">$7,500</div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon user">4️⃣</div>
                        <div class="activity-details">
                            <h4>Sophie Bernard</h4>
                            <p>4 cartes actives</p>
                        </div>
                        <div class="activity-time">$6,000</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>