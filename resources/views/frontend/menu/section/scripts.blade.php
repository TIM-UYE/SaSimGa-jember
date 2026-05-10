 <script>
        // Store current modal menu ID
        let currentModalMenuId = null;

        // Search functionality
        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const menuCards = document.querySelectorAll('.menu-card');
            let hasResults = false;

            menuCards.forEach(card => {
                const menuName = card.querySelector('h3').textContent.toLowerCase();
                const menuDesc = card.querySelector('p').textContent.toLowerCase();

                if (menuName.includes(searchTerm) || menuDesc.includes(searchTerm)) {
                    card.style.display = 'block';
                    hasResults = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message
            const noResults = document.getElementById('noResults');
            if (noResults) {
                noResults.classList.toggle('hidden', hasResults || !searchTerm);
            }
        });

        function filterMenuByCategory(categoryId) {
            // Update button styles
            document.querySelectorAll('.kategori-btn').forEach(btn => {
                if (parseInt(btn.dataset.kategoriId) === parseInt(categoryId)) {
                    btn.classList.remove('bg-gray-800', 'text-gray-300');
                    btn.classList.add('text-white', 'bg-orange-500', 'shadow-lg', 'shadow-orange-500/25');
                } else {
                    btn.classList.add('bg-gray-800', 'text-gray-300');
                    btn.classList.remove('text-white', 'bg-orange-500', 'shadow-lg', 'shadow-orange-500/25');
                }
            });

            const menuCards = document.querySelectorAll('.menu-card');

            menuCards.forEach(card => {
                const menuCategoryId = parseInt(card.getAttribute('data-kategori-id'));
                const filterCategoryId = parseInt(categoryId);

                if (filterCategoryId === 0 || menuCategoryId === filterCategoryId) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.3s ease-in-out';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Quick add to cart (direct add without showing quantity selector)
        function quickAddToCart(menuId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/cart/add/' + menuId;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';

            const qtyInput = document.createElement('input');
            qtyInput.type = 'hidden';
            qtyInput.name = 'qty';
            qtyInput.value = '1';

            form.appendChild(csrfInput);
            form.appendChild(qtyInput);
            document.body.appendChild(form);
            form.submit();
        }

        function openMenuDetail(menu) {
            currentModalMenuId = menu.id;

            // Reset modal quantity
            document.getElementById('modalQtyInput').value = 1;

            // IMAGE
            const imagePath = menu.gambar ?
                `{{ asset('storage/menu/') }}/${menu.gambar}` :
                '';

            document.getElementById('modalImage').src =
                imagePath || '{{ asset('images/placeholder.jpg') }}';

            // TITLE
            document.getElementById('modalMenuName').textContent =
                menu.nama_menu;

            // CATEGORY
            document.getElementById('modalCategory').innerHTML =
                menu.kategori ?
                `<span>${menu.kategori.nama_kategori}</span>` :
                '<span>Menu Pilihan</span>';

            // PRICE
            const price = new Intl.NumberFormat(
                'id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }
            ).format(menu.harga);

            document.getElementById('modalPrice').textContent = price;

            // STATUS
            document.getElementById('modalStatus').innerHTML = menu.is_available ?
                `
            <div class="flex items-center gap-2">
                <span class="inline-block w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-green-400 font-semibold">Tersedia</span>
            </div>
        ` :
                `
            <div class="flex items-center gap-2">
                <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                <span class="text-red-400 font-semibold">Tidak Tersedia</span>
            </div>
        `;

            // DESCRIPTION
            document.getElementById('modalDescription').textContent =
                menu.deskripsi || 'Tidak ada deskripsi';

            // BAHAN
            if (menu.bahan) {
                document.getElementById('modalBahan').textContent = menu.bahan;
                document.getElementById('bahanSection').classList.remove('hidden');
            } else {
                document.getElementById('bahanSection').classList.add('hidden');
            }

            // UKURAN
            if (menu.ukuran) {
                document.getElementById('modalUkuran').textContent = menu.ukuran;
                document.getElementById('ukuranInfo').classList.remove('hidden');
            } else {
                document.getElementById('ukuranInfo').classList.add('hidden');
            }

            // DURASI
            if (menu.durasi_persiapan) {
                document.getElementById('modalDurasi').textContent =
                    `${menu.durasi_persiapan} menit`;
                document.getElementById('durasiInfo').classList.remove('hidden');
            } else {
                document.getElementById('durasiInfo').classList.add('hidden');
            }

            // BUTTON
            const orderBtn = document.getElementById('modalOrderBtn');

            if (!menu.is_available) {
                orderBtn.disabled = true;
                orderBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                orderBtn.disabled = false;
                orderBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }

            // OPEN MODAL
            document.getElementById('menuDetailModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Modal quantity controls
        function increaseModalQty() {
            const input = document.getElementById('modalQtyInput');
            let value = parseInt(input.value) || 1;
            if (value < 99) {
                input.value = value + 1;
            }
        }

        function decreaseModalQty() {
            const input = document.getElementById('modalQtyInput');
            let value = parseInt(input.value) || 1;
            if (value > 1) {
                input.value = value - 1;
            }
        }

        // Add to cart from modal
        function addToCartFromModal() {
            if (!currentModalMenuId) return;

            const qty = document.getElementById('modalQtyInput').value;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/cart/add/' + currentModalMenuId;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';

            const qtyInput = document.createElement('input');
            qtyInput.type = 'hidden';
            qtyInput.name = 'qty';
            qtyInput.value = qty;

            form.appendChild(csrfInput);
            form.appendChild(qtyInput);
            document.body.appendChild(form);
            form.submit();
        }

        function closeMenuDetail(event) {
            if (event && event.target.id !== 'menuDetailModal') return;

            document.getElementById('menuDetailModal').classList.add('hidden');
            document.body.style.overflow = 'auto';

            currentModalMenuId = null;
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeMenuDetail();
            }
        });

        // Floating checkout button
        function updateFloatingCheckout() {
            fetch('{{ route('cart.count') }}')
                .then(response => response.json())
                .then(data => {
                    const floatingCheckout = document.getElementById('floatingCheckout');
                    const floatingTotal = document.getElementById('floatingTotal');

                    if (data.count > 0) {
                        floatingCheckout.classList.remove('hidden');
                        floatingTotal.textContent = data.total_formatted;
                    } else {
                        floatingCheckout.classList.add('hidden');
                    }
                })
                .catch(() => {
                    document.getElementById('floatingCheckout').classList.add('hidden');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Set initial active category button
            const firstBtn = document.querySelector('.kategori-btn');
            if (firstBtn) {
                firstBtn.classList.add('text-white', 'bg-orange-500', 'shadow-lg', 'shadow-orange-500/25');
                firstBtn.classList.remove('bg-gray-800', 'text-gray-300');
            }

            // Initialize floating checkout
            updateFloatingCheckout();
        });

        // Re-check floating checkout when page regains focus
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                updateFloatingCheckout();
            }
        });

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        function showMenuSection(type) {

            const regular = document.getElementById('regularMenuSection');
            const special = document.getElementById('specialMenuSection');

            const regularBtn = document.getElementById('regularBtn');
            const specialBtn = document.getElementById('specialBtn');

            if (type === 'regular') {

                regular.classList.remove('hidden');
                special.classList.add('hidden');

                regularBtn.classList.add('bg-orange-500');
                specialBtn.classList.remove('bg-orange-500');

            } else {

                regular.classList.add('hidden');
                special.classList.remove('hidden');

                specialBtn.classList.add('bg-orange-500');
                regularBtn.classList.remove('bg-orange-500');

            }

            window.scrollTo({
                top: document.getElementById(type === 'regular' ?
                    'regularMenuSection' :
                    'specialMenuSection').offsetTop - 100,
                behavior: 'smooth'
            });
        }

        function openSpecialModal() {
            document.getElementById('specialMenuModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSpecialModal() {
            document.getElementById('specialMenuModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function selectSpecialItem(type) {

            document.getElementById('specialTitle').textContent =
                `Tumpeng ${type}`;
        }

        function closeSpecialModal(event) {

            if (event && event.target.id !== 'specialMenuModal') return;

            document.getElementById('specialMenuModal').classList.add('hidden');

            document.body.style.overflow = 'auto';
        }
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #f97316;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #ea580c;
        }
    </style>