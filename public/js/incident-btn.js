function generatePatientFields(casualtiesCount, container, containerType) {
    console.log(`Generating fields for ${casualtiesCount} casualties in container: ${containerType}...`);

    if (!isNaN(casualtiesCount) && casualtiesCount > 0) {
        container.innerHTML = ''; // Clear existing rows

        for (let i = 0; i < casualtiesCount; i++) {
            const patientFields = `
                <div class="row patient-row">
                    <div class="col-12 col-md-4 mb-2">
                        <input type="text" class="form-control" name="${containerType}[${i}][full_name]" id="${containerType}_${i}_full_name">
                        <small for="${containerType}_${i}_full_name" class="form-label text-primary">Patient Name</small>
                    </div>
                    <div class="col-12 col-md-3 mb-2">
                        <input type="number" class="form-control" name="${containerType}[${i}][heart_rate]" id="${containerType}_${i}_heart_rate">
                        <small for="${containerType}_${i}_heart_rate" class="form-label text-primary">Heart Rate (BPM)</small>
                    </div>
                    <div class="col-12 col-md-2 mb-2">
                        <input type="checkbox" class="form-check-input" id="${containerType}_${i}_shortness_breath" name="${containerType}[${i}][shortness_breath]">
                        <small for="${containerType}_${i}_shortness_breath" class="form-check-label text-primary">Shortness of Breath</small>
                    </div>
                    <div class="col-12 col-md-2 mb-2">
                        <input type="checkbox" class="form-check-input" id="${containerType}_${i}_paleness" name="${containerType}[${i}][paleness]">
                        <small for="${containerType}_${i}_paleness" class="form-check-label text-primary">Paleness</small>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', patientFields);
        }
    } else {
        console.error('Invalid casualties count or missing incident type.');
    }
}

// Adjust the input listener to pass container types
document.addEventListener('DOMContentLoaded', function () {
    const incidentTypeSelect = document.getElementById('incident_type');
    const incidentFields = document.querySelectorAll('.incident-fields');
    const numberCasualtiesInput = document.getElementById('number_casualties');
    const medicalContainer = document.getElementById('medical-container');
    const injuryTraumaContainer = document.getElementById('injury-trauma-container');
    const cardiaContainer = document.getElementById('cardia-container');
    const disasterContainer = document.getElementById('disaster-container');

    function toggleFields(selectedType) {
        if (selectedType === "1") {
            numberCasualtiesInput.closest('div').classList.add('d-none');
        } else {
            numberCasualtiesInput.closest('div').classList.remove('d-none');
        }

        incidentFields.forEach(field => field.classList.add('d-none'));
        if (selectedType) {
            const selectedField = document.getElementById(`${selectedType}-fields`);
            if (selectedField) {
                selectedField.classList.remove('d-none');
            }
        }
    }

    toggleFields(incidentTypeSelect.value);

    incidentTypeSelect.addEventListener('change', function () {
        toggleFields(this.value);
    });

    numberCasualtiesInput.addEventListener('input', function () {
        const casualtiesCount = parseInt(this.value, 10) || 0;

        console.log(`Number of casualties: ${casualtiesCount}`);

        if (casualtiesCount > 0) {
            generatePatientFields(casualtiesCount, medicalContainer, 'medical');
            generatePatientFields(casualtiesCount, injuryTraumaContainer, 'injury_trauma');
            generatePatientFields(casualtiesCount, cardiaContainer, 'cardia');
            generatePatientFields(casualtiesCount, disasterContainer, 'disaster');
        } else {
            medicalContainer.innerHTML = '';
            injuryTraumaContainer.innerHTML = '';
            cardiaContainer.innerHTML = '';
            disasterContainer.innerHTML = '';
        }
    });
});
