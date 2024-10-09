let amounts = [];
let created_ats = [];


$('.amount').each(function () {
    let amount = parseFloat($(this).text());
    if (!isNaN(amount)) {
        amounts.push(amount);
    }
});

$('.created_at').each(function () {
    let createdAtString = $(this).text();
    let createdAtDate = new Date(createdAtString);

    let formattedDate =
        createdAtDate.getDate().toString().padStart(2, '0') + '.' +
        (createdAtDate.getMonth() + 1).toString().padStart(2, '0') + '.' +
        createdAtDate.getFullYear();

    if (!isNaN(createdAtDate.getTime())) {
        created_ats.push(formattedDate);
    }
});

let ctx = document.getElementById('myChart');
if(ctx !== null){
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: created_ats,
            datasets: [{
                label: '#',
                data: amounts,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
