// 1. Converting HTML table to PDF

const pdf_btn = document.querySelector('#toPDF');

const customers_table = document.querySelector('#customers_table');

const toPDF = function (customers_table) {
    const html_code=`
    <link rel="stylesheet" href="report.css">
    <main class="table">${customers_table.innerHTML}</main>   
    `;
    const new_window=window.open();
    new_window.document.write(html_code);


    setTimeout(() => {
        new_window.print();
        new_window.close();
    }, 200);
}

pdf_btn.onclick = () => {
    toPDF(customers_table);
}


// 2. Converting HTML table to JSON

const json_btn = document.querySelector('#toJSON');

const toJSON = function (table) {
    let table_data = [],
    t_head = [],

        t_headings = table.querySelectorAll('th'),
        t_rows = table.querySelectorAll('tr');


        for (let t_heading of t_headings) {

            let actual_head = t_heading.textContent.trim();
            t_head.push(actual_head.trim().toLowerCase());
        }


        t_rows.forEach(row => {
            const row_object = {},
                t_cells = row.querySelectorAll('td');
    
            t_cells.forEach((t_cell, cell_index) => {
                row_object[t_head[cell_index]] = t_cell.textContent.trim();
            })
            table_data.push(row_object);
        })
        return JSON.stringify(table_data, null, 4);
}

json_btn.onclick = () => {
    const json= toJSON(customers_table);
    downloadFile(json,'json');
}




// 3. Converting HTML table to CSV File

const csv_btn = document.querySelector('#toCSV');

const toCSV = function (table) {
    const t_rows = table.querySelectorAll('tr');
    return [...t_rows].map(row => {
        const cells = row.querySelectorAll('th, td');
        return [...cells].map(cell => cell.textContent.trim()).join(',');
    }).join('\n');
}

csv_btn.onclick = () => {
    const csv = toCSV(customers_table);
    downloadFile(csv, 'csv');
}





// 4. Converting HTML table to EXCEL File

const excel_btn = document.querySelector('#toEXCEL');

const toExcel = function (table) {
    const t_rows = table.querySelectorAll('tr');
    return [...t_rows].map(row => {
        const cells = row.querySelectorAll('th, td');
        return [...cells].map(cell => cell.textContent.trim()).join('\t');
    }).join('\n');
}

excel_btn.onclick = () => {
    const excel = toExcel(customers_table);
    downloadFile(excel,'excel');
}





const downloadFile = function (data, fileType, fileName = 'Score') {
    const a = document.createElement('a');
    a.download = fileName;
    const mime_types = {
        'json': 'application/json',
        'csv': 'text/csv',
        'excel': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    }
    a.href = `
        data:${mime_types[fileType]};charset=utf-8,${data}
    `;
    document.body.appendChild(a);
    a.click();
    a.remove();
}


