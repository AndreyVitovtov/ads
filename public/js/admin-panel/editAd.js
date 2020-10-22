class RubricSubsection {
    init() {
        this.rubrics = document.getElementById('rubric');
        this.subsections = document.getElementById('subsection');

        this.bindEvents();
    }

    bindEvents() {
        this.rubrics.addEventListener('change', e => {
            let rubricId = e.target.value;
            this.getSubsections(rubricId);
        });
    }

    getSubsections(rubricId) {
        $.ajax({
            type: 'POST',
            url: '/api/get/subsections',
            data: {
                id : rubricId
            },
            success: data => {
                let subsections = "";
                data.forEach(s => {
                    subsections += `<option value="${s.id}">${s.name}</option>`;
                });
                this.subsections.innerHTML = subsections;
            }
        });
    }
}

class CountryCity {
    init() {
        this.countries = document.getElementById('country');
        this.cities = document.getElementById('city');

        this.bindEvents();
    }

    bindEvents() {
        this.countries.addEventListener('change', e => {
            let countryId = e.target.value;
            this.getCities(countryId);
        });
    }

    getCities(countryId) {
        $.ajax({
            type: 'POST',
            url: '/api/get/cities',
            data: {
                id : countryId
            },
            success: data => {
                let cities = "";
                data.forEach(s => {
                    cities += `<option value="${s.id}">${s.name}</option>`;
                });
                this.cities.innerHTML = cities;
            }
        });
    }
}


window.addEventListener('load', () => {
    let rubricSubsection = new RubricSubsection();
    rubricSubsection.init();
    let countryCity = new CountryCity();
    countryCity.init();
});

