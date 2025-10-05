@vite(['resources/css/connections.css', 'resources/js/connections.js'])

<div class="connect-page">
    <div class="container">

        <!-- Left Column -->
        <div class="left-column">
            <h1>Find Partner</h1>

            <div class="search-filter-wrapper">
                <input type="text" class="search-input" placeholder="Search users..." id="searchInput">

                <div class="filters-wrapper">
                    <button class="filters-button" id="filtersBtn">
                        <x-tabler-filter class="w-5 h-5" />
                    </button>

                    <div class="filters-dropdown" id="filtersDropdown">
                        <button aria-pressed="false">English</button>
                        <button aria-pressed="false">Mandarin</button>
                        <button aria-pressed="false">German</button>
                        <button aria-pressed="false">Serious Learner</button>
                    </div>
                </div>
            </div>


            <div class="user-list" id="userList">
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
                <x-user-item />
            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <h2>Pending Requests</h2>
            <div class="pending-list">
                <div class="pending-item">
                    <span>Request 1</span>
                    <button class="pending-decline">
                        <x-tabler-x />
                    </button>
                </div>
                <div class="pending-item">
                    <span>Request 2</span>
                    <button class="pending-decline">
                        <x-tabler-x />
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>