// Function to add a new row to the table
document.getElementById("addRowBtn").addEventListener("click", function() {
    let table = document.getElementById("familyTable").getElementsByTagName('tbody')[0];
    let newRow = table.insertRow(table.rows.length);
    
    let rowIndex = table.rows.length - 1;

    // Create cells and append to the row
    for (let i = 0; i < 8; i++) {
        let cell = newRow.insertCell(i);

        if (i === 4) { 
            // Create the select dropdown for gender
            cell.innerHTML = `<select name="family_member[${rowIndex}][${i}]" class="form-control">` + 
                genders.map(gender => `<option value="${gender.id}">${gender.name}</option>`).join('') + 
                '</select>';
        }else if(i === 2){
            cell.innerHTML = `<input type="date" name="family_member[${rowIndex}][${i}]" class="form-control">`;
        }else {
            // General input for other cells
            cell.innerHTML = `<input type="text" name="family_member[${rowIndex}][${i}]" class="form-control">`;
        }
    }
    
    let deleteCell = newRow.insertCell(8); 
    deleteCell.innerHTML = `
        <button type="button" class="btn btn-danger btn-sm deleteBtn">
            Delete
        </button>
    `;
    
    // Add event listener for delete button
    deleteCell.querySelector(".deleteBtn").addEventListener("click", function() {
        newRow.remove(); // Remove the row from the table
    });
});