<?php
include "../libs/load.php";

Session::start();
$user = Operations::getUser();
$users = Operations::getUsers();
if (!Session::get('login_user')) {
    header("Location: welcome.php");
    exit;
} elseif ($user['status'] === 'not') {
    header("Location: otp_verify.php");
    exit;
}

shuffle($users);

include "header.php";
?>

<style>
    :root {
        --adjust-size: 0px;
    }

    #gallery-container {
        padding: 5rem 0;
    }

    #gallery {
        position: relative;
        left: calc(-1 * var(--adjust-size));
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
        max-width: 100vw;
        padding: 20px;
        perspective: 0;
    }

    #gallery figure {
        --angle: 3deg;
        --duration: 1s;
        --delay: -0.5s;
        --direction: alternate;
        --pin-color: crimson;

        position: relative;
        margin: var(--adjust-size);
        padding: 0.5rem;
        border-radius: 5px;
        box-shadow: 0 7px 8px rgba(0, 0, 0, 0.4);
        width: 100%;
        background-color: ghostwhite;
        transform-origin: center 0.22rem;
        break-inside: avoid;
        overflow: hidden;
        backface-visibility: hidden;
    }

    #gallery.active figure {
        animation: swing var(--duration) ease-in-out var(--delay) 5 var(--direction) both,
                   swingEnd 1.5s ease-in-out calc(var(--delay) + var(--duration) * 5) 1 normal both;
    }

    #gallery figure:after {
        content: "";
        position: absolute;
        top: 0.22rem;
        left: 50%;
        width: 0.7rem;
        height: 0.7rem;
        background: var(--pin-color);
        border-radius: 50%;
        box-shadow: -0.1rem -0.1rem 0.3rem 0.02rem rgba(0, 0, 0, 0.5) inset;
        filter: drop-shadow(0.3rem 0.15rem 0.2rem rgba(0, 0, 0, 0.5));
        transform: translateX(-50%);
        z-index: 2;
    }

    #gallery figure img {
        aspect-ratio: 1 / 1;
        width: 100%;
        object-fit: cover;
        display: block;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    #gallery figure figcaption {
        font-size: 14px;
        font-weight: 400;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    #gallery figure:nth-child(7n) { --pin-color: crimson; --duration: 1s; }
    #gallery figure:nth-child(7n + 1) { --pin-color: hotpink; --duration: 1.8s; }
    #gallery figure:nth-child(7n + 2) { --pin-color: magenta; --duration: 1.3s; }
    #gallery figure:nth-child(7n + 3) { --pin-color: orangered; --duration: 1.5s; }
    #gallery figure:nth-child(7n + 4) { --pin-color: darkorchid; --duration: 1.1s; }
    #gallery figure:nth-child(7n + 5) { --pin-color: deeppink; --duration: 1.6s; }
    #gallery figure:nth-child(7n + 6) { --pin-color: mediumvioletred; --duration: 1.2s; }

    #gallery figure:nth-child(3n) { --angle: 3deg; }
    #gallery figure:nth-child(3n + 1) { --angle: -3.3deg; }
    #gallery figure:nth-child(3n + 2) { --angle: 2.4deg; }

    #gallery figure:nth-child(odd) { --direction: alternate; }
    #gallery figure:nth-child(even) { --direction: alternate-reverse; }

    @keyframes swing {
        0% { transform: rotate3d(0, 0, 1, calc(-1 * var(--angle))); }
        100% { transform: rotate3d(0, 0, 1, var(--angle)); }
    }

    @keyframes swingEnd {
        to { transform: rotate3d(0, 0, 1, 0deg); }
    }

    .filter-toggle-button {
        display: none;
    }

    .filter-section {
        background: #fff;
        padding: 1.5rem;
        margin: 8rem 0 0 0;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        margin-top: 1rem;
    }

    .filter-title {
        font-size: 1.5rem;
        color: #333;
        font-weight: 600;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .filter-group {
        margin-bottom: 0.5rem;
    }

    .filter-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #555;
    }

    .filter-select {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #fff;
        font-size: 0.9rem;
    }

    .filter-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 1rem;
    }

    .filter-button {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
    }

    .filter-apply {
        background: #4CAF50;
        color: white;
    }

    .filter-reset {
        background: #f44336;
        color: white;
    }

    .filter-button:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .user-card.hidden {
        display: none;
    }

    @media (max-width: 768px) {
        .filter-toggle-button {
            display: block;
            background-color: #4CAF50;
            color: white;
            padding: 0.75rem;
            font-size: 1rem;
            border: none;
            border-radius: 4px;
            margin: 8rem 0 0 1rem;
            cursor: pointer;
        }

        .filter-section {
            margin: 0;
        }

        .collapsible-filters {
            display: none;
        }

        .collapsible-filters.active {
            display: block;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        #gallery {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
    }
</style>

<!-- Only visible on mobile -->
<button class="filter-toggle-button" onclick="toggleFilterMenu()">☰ Filters</button>

<!-- Filter Section -->
<section class="filter-section collapsible-filters">
    <div class="filter-header">
        <h2 class="filter-title">Filter Profiles</h2>
    </div>

    <div class="filter-grid">
        <?php
        $filterOptions = [
            'gender' => ['label' => 'Gender', 'options' => ['Male', 'Female']],
            'religion' => ['label' => 'Religion', 'options' => array_unique(array_column($users, 'religion'))],
            'caste' => ['label' => 'Caste', 'options' => array_unique(array_column($users, 'caste'))],
            'tongue' => ['label' => 'Mother Tongue', 'options' => array_unique(array_column($users, 'mother_tongue'))],
            'subcaste' => ['label' => 'Sub Caste', 'options' => array_unique(array_column($users, 'sub_caste'))],
            'creator' => ['label' => 'Profile Created By', 'options' => array_unique(array_column($users, 'profile_created_by'))],
        ];

        foreach ($filterOptions as $key => $data):
        ?>
        <div class="filter-group">
            <label for="<?= $key ?>-filter"><?= $data['label'] ?></label>
            <select id="<?= $key ?>-filter" class="filter-select">
                <option value="">All <?= $data['label'] ?>s</option>
                <?php foreach ($data['options'] as $option): if (!empty($option)): ?>
                    <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
                <?php endif; endforeach; ?>
            </select>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="filter-actions">
        <button id="reset-filters" class="filter-button filter-reset">Reset Filters</button>
        <button id="apply-filters" class="filter-button filter-apply">Apply Filters</button>
    </div>
</section>

<section id="gallery-container">
    <div class="container">
        <div id="gallery">
            <?php foreach ($users as $u): ?>
            <figure class="user-card"
                data-gender="<?= htmlspecialchars($u['gender']) ?>"
                data-religion="<?= htmlspecialchars($u['religion']) ?>"
                data-caste="<?= htmlspecialchars($u['caste']) ?>"
                data-tongue="<?= htmlspecialchars($u['mother_tongue']) ?>"
                data-subcaste="<?= htmlspecialchars($u['sub_caste']) ?>"
                data-creator="<?= htmlspecialchars($u['profile_created_by']) ?>">
                <a href="profile.php?username=<?= htmlspecialchars($u['name']) ?>">
                    <?php if ($u['payment'] === "paid") { ?>
                        <img src="<?= htmlspecialchars($u['profile_img']) ?>" alt="Profile image of <?= htmlspecialchars($u['name']) ?>">
                    <?php
                        } elseif ($u['gender'] === "Male") {
                            if ($u['name'] === $user['name']) {
                    ?>
                        <img src="<?= htmlspecialchars($u['profile_img']) ?>" alt="Profile image of <?= htmlspecialchars($u['name']) ?>">
                        <?php } else { ?>
                            <img src="assets/img/male.png" alt="Profile image of <?= htmlspecialchars($u['name']) ?>">
                        <?php } ?>
                    <?php
                        } else {
                            if ($u['name'] === $user['name']) {
                    ?>
                                <img src="<?= htmlspecialchars($u['profile_img']) ?>" alt="Profile image of <?= htmlspecialchars($u['name']) ?>">
                        <?php } else { ?>
                                <img src="assets/img/female.png" alt="Profile image of <?= htmlspecialchars($u['name']) ?>">
                        <?php } ?>
                    <?php } ?>
                    <figcaption style="color: #000; justify-self: center;"><?= htmlspecialchars($u['name']) ?></figcaption>
                </a>
            </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
    function toggleFilterMenu() {
        const filterSection = document.querySelector('.collapsible-filters');
        filterSection.classList.toggle('active');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const filters = {
            gender: document.getElementById('gender-filter'),
            religion: document.getElementById('religion-filter'),
            caste: document.getElementById('caste-filter'),
            tongue: document.getElementById('tongue-filter'),
            subcaste: document.getElementById('subcaste-filter'),
            creator: document.getElementById('creator-filter')
        };

        const resetButton = document.getElementById('reset-filters');
        const applyButton = document.getElementById('apply-filters');
        const userCards = document.querySelectorAll('.user-card');

        function applyFilters() {
            const values = Object.fromEntries(Object.entries(filters).map(([k, el]) => [k, el.value]));

            userCards.forEach(card => {
                const visible = Object.entries(values).every(([k, v]) => !v || card.dataset[k] === v);
                card.classList.toggle('hidden', !visible);
            });
        }

        applyButton.addEventListener('click', applyFilters);

        resetButton.addEventListener('click', () => {
            Object.values(filters).forEach(el => el.value = '');
            applyFilters();
        });
    });
</script>

<?php include "footer.php" ?>