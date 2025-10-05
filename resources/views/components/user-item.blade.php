<div class="user-item">
    <header class="user-item-header">
        <x-avatar class="user-avatar" />

        <div class="user-header-info">
            <h5 class="user-name">{{ $name }}</h5>
        </div>
    </header>

    <p class="user-description">
        {{ $description }}
    </p>

    <footer>
        <div class="user-footer">
            <span>{{ $l1 }}</span>
            <span><x-tabler-transfer /></span>
            <span>{{ $l2 }}</span>
        </div>
    </footer>

    <section class="connect-button">
            <span><x-tabler-user-plus/></span>
    </section>
</div>