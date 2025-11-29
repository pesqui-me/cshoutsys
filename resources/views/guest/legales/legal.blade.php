<x-guest-layout>
    <x-slot name="title">Mentions Légales</x-slot>

    <section class="py-20 bg-white">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Mentions Légales</h1>
                <p class="text-gray-600">Informations légales et réglementaires</p>
            </div>

            <div class="prose prose-lg max-w-none">
                <h2>1. Éditeur du site</h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <p><strong>Raison sociale</strong> : PRIME BLOCK SAS</p>
                    <p><strong>Capital social</strong> : 100 000 €</p>
                    <p><strong>Siège social</strong> : 123 Avenue des Champs-Élysées, 75008 Paris, France</p>
                    <p><strong>RCS</strong> : Paris B 123 456 789</p>
                    <p><strong>SIRET</strong> : 123 456 789 00012</p>
                    <p><strong>TVA intracommunautaire</strong> : FR 12 123456789</p>
                    <p><strong>Directeur de publication</strong> : [Nom du dirigeant]</p>
                    <p><strong>Email</strong> : contact@primeblock.com</p>
                    <p><strong>Téléphone</strong> : +33 1 23 45 67 89</p>
                </div>

                <h2>2. Hébergement</h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <p><strong>Hébergeur</strong> : OVH SAS</p>
                    <p><strong>Siège social</strong> : 2 rue Kellermann, 59100 Roubaix, France</p>
                    <p><strong>Téléphone</strong> : 1007</p>
                    <p><strong>Site web</strong> : www.ovh.com</p>
                </div>

                <h2>3. Propriété intellectuelle</h2>
                <p>
                    L'ensemble du contenu présent sur le site PRIME BLOCK (structure, textes, logos, images, vidéos, sons, bases de données, logiciels, etc.) est protégé par les droits de propriété intellectuelle.
                </p>
                <p>
                    Toute reproduction, représentation, modification, publication, transmission, dénaturation, totale ou partielle du site ou de son contenu, par quelque procédé que ce soit, et sur quelque support que ce soit est interdite sans l'autorisation écrite préalable de PRIME BLOCK.
                </p>

                <h2>4. Protection des données personnelles</h2>
                <p>
                    Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez d'un droit d'accès, de rectification, de suppression et d'opposition aux données personnelles vous concernant.
                </p>
                <p>
                    Pour exercer ces droits, vous pouvez nous contacter à : privacy@primeblock.com
                </p>
                <p>
                    Pour plus d'informations, consultez notre <a href="{{ route('privacy') }}" class="text-primary-600 hover:text-primary-700">Politique de Confidentialité</a>.
                </p>

                <h2>5. Cookies</h2>
                <p>
                    Le site PRIME BLOCK utilise des cookies pour améliorer l'expérience utilisateur. En naviguant sur ce site, vous acceptez l'utilisation de cookies conformément à notre politique de cookies.
                </p>
                <p>
                    Vous pouvez désactiver les cookies dans les paramètres de votre navigateur, mais cela peut affecter certaines fonctionnalités du site.
                </p>

                <h2>6. Responsabilité</h2>
                <p>
                    PRIME BLOCK s'efforce d'assurer l'exactitude et la mise à jour des informations diffusées sur ce site. Toutefois, PRIME BLOCK ne peut garantir l'exactitude, la précision ou l'exhaustivité des informations disponibles sur le site.
                </p>
                <p>
                    PRIME BLOCK décline toute responsabilité :
                </p>
                <ul>
                    <li>Pour toute imprécision, inexactitude ou omission portant sur des informations disponibles sur le site</li>
                    <li>Pour tout dommage résultant d'une intrusion frauduleuse d'un tiers</li>
                    <li>Pour tout dommage direct ou indirect causé au matériel de l'utilisateur lors de l'accès au site</li>
                </ul>

                <h2>7. Liens hypertextes</h2>
                <p>
                    Le site PRIME BLOCK peut contenir des liens vers d'autres sites internet. PRIME BLOCK n'exerce aucun contrôle sur ces sites et décline toute responsabilité quant à leur contenu.
                </p>

                <h2>8. Droit applicable et juridiction</h2>
                <p>
                    Les présentes mentions légales sont régies par le droit français. En cas de litige et à défaut d'accord amiable, le litige sera porté devant les tribunaux français compétents.
                </p>

                <h2>9. Médiation</h2>
                <p>
                    Conformément aux articles L.616-1 et R.616-1 du Code de la consommation, nous proposons un dispositif de médiation de la consommation.
                </p>
                <p>
                    L'entité de médiation retenue est :
                </p>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <p><strong>Médiateur de la consommation</strong> : [Nom du médiateur]</p>
                    <p><strong>Adresse</strong> : [Adresse]</p>
                    <p><strong>Site web</strong> : [URL]</p>
                </div>

                <h2>10. Contact</h2>
                <p>
                    Pour toute question relative aux mentions légales, vous pouvez nous contacter :
                </p>
                <ul>
                    <li>Par email : legal@primeblock.com</li>
                    <li>Par téléphone : +33 1 23 45 67 89</li>
                    <li>Par courrier : PRIME BLOCK SAS, 123 Avenue des Champs-Élysées, 75008 Paris</li>
                </ul>
            </div>

            <div class="mt-12 p-6 bg-primary-50 rounded-xl border border-primary-200">
                <p class="text-sm text-gray-700">
                    <strong>Dernière mise à jour</strong> : {{ date('d/m/Y') }}
                </p>
            </div>
        </div>
    </section>
</x-guest-layout>