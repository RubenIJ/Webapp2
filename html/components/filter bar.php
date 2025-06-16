

<div id="filterBox" style="display:none;">
    <h4>Filter op tags:</h4>
    <div class="filter-bar-indeling">
        <div>
        <label><input type="checkbox" value="familie"> Familie</label><br>
        <label><input type="checkbox" value="all-inclusive"> All-inclusive</label><br>
        <label><input type="checkbox" value="zee"> Zee</label><br>
        <label><input type="checkbox" value="zon"> Zon</label><br>
        <label><input type="checkbox" value="actief"> Actief</label><br>
        <label><input type="checkbox" value="sneeuw"> Sneeuw</label><br>
        <label><input type="checkbox" value="hotel"> Hotel</label><br>
        <label><input type="checkbox" value="gevaar"> Gevaar</label><br>
        <label><input type="checkbox" value="eigen-risico"> Eigen-risico</label><br></div>
    <div><h4>Filter op prijs:</h4>
        <label><input type="checkbox" class="prijs-filter" value="onder500"> Onder €500</label><br>
        <label><input type="checkbox" class="prijs-filter" value="tussen500en1000"> €500 - €1000</label><br>
        <label><input type="checkbox" class="prijs-filter" value="boven1000"> Boven €1000</label><br>
    </div></div></div>



<script>// Toggle filterbox
    document.getElementById('filterToggle').addEventListener('click', function () {
        const box = document.getElementById('filterBox');
        box.style.display = box.style.display === 'none' ? 'block' : 'none';
    });

    // Filter op tags
    const checkboxes = document.querySelectorAll('#filterBox input[type="checkbox"]');

    checkboxes.forEach(box => {
        box.addEventListener('change', function () {
            const actieveTags = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value.toLowerCase());

            kaarten.forEach(kaart => {
                const kaartTags = kaart.querySelector('#kaart-tags').textContent.toLowerCase();
                const zichtbaar = actieveTags.length === 0 || actieveTags.some(tag => kaartTags.includes(tag));
                kaart.style.display = zichtbaar ? 'block' : 'none';
            });
        });
    });</script>
<script>const prijsCheckboxes = document.querySelectorAll('.prijs-filter');

    prijsCheckboxes.forEach(cb => {
        cb.addEventListener('change', filterOpPrijs);
    });

    function filterOpPrijs() {
        const geselecteerdePrijzen = Array.from(prijsCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        kaarten.forEach(kaart => {
            const prijsTekst = kaart.querySelector('p').textContent;
            const prijsMatch = prijsTekst.match(/€\s?(\d+)/);
            const prijs = prijsMatch ? parseInt(prijsMatch[1]) : 0;

            let zichtbaar = false;
            if (geselecteerdePrijzen.length === 0) {
                zichtbaar = true;
            } else {
                zichtbaar = geselecteerdePrijzen.some(val => {
                    if (val === "onder500") return prijs < 500;
                    if (val === "tussen500en1000") return prijs >= 500 && prijs <= 1000;
                    if (val === "boven1000") return prijs > 1000;
                });
            }

            // combineer met tagfilter
            const actieveTags = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value.toLowerCase());

            const kaartTags = kaart.querySelector('#kaart-tags').textContent.toLowerCase();
            const tagMatch = actieveTags.length === 0 || actieveTags.some(tag => kaartTags.includes(tag));

            kaart.style.display = (zichtbaar && tagMatch) ? 'block' : 'none';
        });
    }
</script>