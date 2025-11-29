<x-guest-layout>
    <x-slot name="title">Politique de Confidentialité</x-slot>

    <section class="py-20 bg-white">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Politique de Confidentialité</h1>
                <p class="text-gray-600">Dernière mise à jour : {{ date('d/m/Y') }}</p>
            </div>

            <div class="prose prose-lg max-w-none">
                <h2>1. Introduction</h2>
                <p>
                    PRIME BLOCK ("nous", "notre", "nos") s'engage à protéger la confidentialité de vos données personnelles. Cette politique explique comment nous collectons, utilisons et protégeons vos informations.
                </p>

                <h2>2. Données collectées</h2>
                <p>Nous collectons les types de données suivants :</p>
                <ul>
                    <li><strong>Informations d'identification</strong> : nom, prénom, adresse email, numéro de téléphone</li>
                    <li><strong>Informations financières</strong> : historique des transactions, solde du compte</li>
                    <li><strong>Données techniques</strong> : adresse IP, type de navigateur, système d'exploitation</li>
                    <li><strong>Données d'utilisation</strong> : pages visitées, durée des sessions, interactions</li>
                </ul>

                <h2>3. Utilisation des données</h2>
                <p>Vos données sont utilisées pour :</p>
                <ul>
                    <li>Fournir et améliorer nos services</li>
                    <li>Gérer votre compte et vos investissements</li>
                    <li>Traiter vos transactions et retraits</li>
                    <li>Vous envoyer des notifications importantes</li>
                    <li>Assurer la sécurité de la plateforme</li>
                    <li>Respecter nos obligations légales</li>
                </ul>

                <h2>4. Partage des données</h2>
                <p>
                    Nous ne vendons jamais vos données personnelles. Nous pouvons partager vos informations uniquement avec :
                </p>
                <ul>
                    <li>Nos prestataires de services (paiement, hébergement)</li>
                    <li>Les autorités réglementaires si requis par la loi</li>
                    <li>Les institutions financières pour traiter vos transactions</li>
                </ul>

                <h2>5. Sécurité des données</h2>
                <p>
                    Nous mettons en œuvre des mesures de sécurité robustes :
                </p>
                <ul>
                    <li>Cryptage SSL/TLS 256 bits</li>
                    <li>Authentification à deux facteurs</li>
                    <li>Surveillance continue des activités suspectes</li>
                    <li>Accès restreint aux données personnelles</li>
                    <li>Audits de sécurité réguliers</li>
                </ul>

                <h2>6. Vos droits</h2>
                <p>Conformément au RGPD, vous avez le droit de :</p>
                <ul>
                    <li><strong>Accès</strong> : obtenir une copie de vos données</li>
                    <li><strong>Rectification</strong> : corriger vos données inexactes</li>
                    <li><strong>Suppression</strong> : demander la suppression de vos données</li>
                    <li><strong>Portabilité</strong> : recevoir vos données dans un format structuré</li>
                    <li><strong>Opposition</strong> : vous opposer au traitement de vos données</li>
                </ul>

                <h2>7. Cookies</h2>
                <p>
                    Nous utilisons des cookies pour améliorer votre expérience. Vous pouvez gérer vos préférences de cookies dans les paramètres de votre navigateur.
                </p>

                <h2>8. Conservation des données</h2>
                <p>
                    Nous conservons vos données personnelles aussi longtemps que nécessaire pour fournir nos services et respecter nos obligations légales (généralement 5 ans après la fermeture du compte).
                </p>

                <h2>9. Modifications</h2>
                <p>
                    Nous pouvons mettre à jour cette politique de temps en temps. Les changements significatifs vous seront notifiés par email.
                </p>

                <h2>10. Contact</h2>
                <p>
                    Pour toute question concernant cette politique ou pour exercer vos droits, contactez-nous :
                </p>
                <ul>
                    <li>Email : privacy@primeblock.com</li>
                    <li>Téléphone : +33 1 23 45 67 89</li>
                    <li>Adresse : PRIME BLOCK, Paris, France</li>
                </ul>
            </div>

            <div class="mt-12 p-6 bg-primary-50 rounded-xl border border-primary-200">
                <p class="text-sm text-gray-700">
                    <strong>Note importante</strong> : En utilisant PRIME BLOCK, vous acceptez cette politique de confidentialité. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser nos services.
                </p>
            </div>
        </div>
    </section>
</x-guest-layout>