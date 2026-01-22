<x-layouts.gameswap :title="__('Privacy Policy')">
    <div class="container mx-auto py-12 px-4 max-w-4xl">
        <h1 class="text-4xl font-bold text-white mb-8">Privacy Policy & GDPR</h1>

        <div class="space-y-8 text-gray-300">
            <!-- Section 1 -->
            <section class="bg-gray-800 rounded-lg border border-gray-700 p-8">
                <h2 class="text-2xl font-bold text-white mb-4">1. Data Collection</h2>
                <p class="mb-4">
                    GameSwap collects the following personal data to provide our services:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li><strong>Account Information:</strong> Name, email address, password (hashed)</li>
                    <li><strong>Profile Data:</strong> Bio, avatar, game listings</li>
                    <li><strong>Trade Data:</strong> Trade requests, messages, feedback</li>
                    <li><strong>Technical Data:</strong> IP address, browser type, usage logs</li>
                </ul>
            </section>

            <!-- Section 2 -->
            <section class="bg-gray-800 rounded-lg border border-gray-700 p-8">
                <h2 class="text-2xl font-bold text-white mb-4">2. Data Usage</h2>
                <p class="mb-4">
                    Your data is used exclusively for:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li>Providing and improving the GameSwap platform</li>
                    <li>Processing trade requests and communications</li>
                    <li>Sending account notifications and updates</li>
                    <li>Preventing fraud and ensuring platform security</li>
                    <li>Complying with legal obligations</li>
                </ul>
            </section>

            <!-- Section 3 -->
            <section class="bg-gray-800 rounded-lg border border-gray-700 p-8">
                <h2 class="text-2xl font-bold text-white mb-4">3. Your Rights (GDPR)</h2>
                <p class="mb-4">
                    Under the General Data Protection Regulation (GDPR), you have the right to:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li><strong>Access:</strong> Request all data we hold about you</li>
                    <li><strong>Correction:</strong> Correct inaccurate or incomplete data</li>
                    <li><strong>Erasure:</strong> Request deletion of your data ("right to be forgotten")</li>
                    <li><strong>Portability:</strong> Export your data in a machine-readable format</li>
                    <li><strong>Objection:</strong> Object to processing of your data</li>
                    <li><strong>Restrict:</strong> Request restriction of data processing</li>
                </ul>
            </section>

            <!-- Section 4 -->
            <section class="bg-gray-800 rounded-lg border border-gray-700 p-8">
                <h2 class="text-2xl font-bold text-white mb-4">4. Data Security</h2>
                <p>
                    We implement industry-standard security measures to protect your data:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4 mt-4">
                    <li>Passwords are hashed using secure algorithms</li>
                    <li>HTTPS encryption for all communications</li>
                    <li>Regular security audits and updates</li>
                    <li>Limited access to personal data by authorized personnel only</li>
                </ul>
            </section>

            <!-- Section 5 -->
            <section class="bg-gray-800 rounded-lg border border-gray-700 p-8">
                <h2 class="text-2xl font-bold text-white mb-4">5. Data Retention</h2>
                <p>
                    We retain your data as long as your account is active. You can request account deletion at any time, and we will remove your personal data within 30 days, except where required by law.
                </p>
            </section>

            <!-- Section 6 -->
            <section class="bg-gray-800 rounded-lg border border-gray-700 p-8">
                <h2 class="text-2xl font-bold text-white mb-4">6. Third-Party Services</h2>
                <p>
                    GameSwap may use third-party services for:
                </p>
                <ul class="list-disc list-inside space-y-2 ml-4 mt-4">
                    <li>Game data (IGDB API - optional)</li>
                    <li>Analytics</li>
                    <li>Email notifications</li>
                </ul>
                <p class="mt-4">
                    These services are GDPR compliant and process data only as instructed.
                </p>
            </section>

            <!-- Section 7 -->
            <section class="bg-gray-800 rounded-lg border border-gray-700 p-8">
                <h2 class="text-2xl font-bold text-white mb-4">7. Contact Us</h2>
                <p>
                    For privacy inquiries, data requests, or to exercise your GDPR rights, contact us at:
                </p>
                <div class="mt-4 p-4 bg-gray-900 rounded-lg border border-gray-700">
                    <p><strong>Email:</strong> privacy@gameswap.local</p>
                    <p><strong>Response Time:</strong> Within 30 days</p>
                </div>
            </section>

            <!-- Last Updated -->
            <p class="text-sm text-gray-500 text-center">
                Last updated: {{ date('F d, Y') }}
            </p>
        </div>

        <!-- Back Button -->
        <div class="mt-12">
            <a href="/" class="inline-block px-6 py-3 border border-gray-700 hover:border-blue-500 text-gray-300 hover:text-blue-400 font-semibold rounded-full transition">
                ← Back Home
            </a>
        </div>
    </div>
</x-layouts.gameswap>
