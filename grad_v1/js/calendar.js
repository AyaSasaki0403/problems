let currentDate;  // グローバルに宣言
let fetchedData = []; // データを保存するためのグローバル変数

document.addEventListener('DOMContentLoaded', function () {

    // 変数の定義
    // const yearMonthList = document.getElementById('year-month-list');
    // const currentYear = new Date().getFullYear();
    // const currentMonth = new Date().getMonth();
    // currentDate = new Date(); 
    // currentDate.setFullYear(currentYear, currentMonth, 1);

    const calendarBody = document.getElementById('calendar-body');
    const monthYear = document.getElementById('monthYear');
    const prevMonth = document.getElementById('prevMonth');
    const nextMonth = document.getElementById('nextMonth');

    currentDate = new Date();
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth();

    // カレンダー生成関数
    function generateCalendar(date) {
        calendarBody.innerHTML = ''; // カレンダーをクリア
        monthYear.textContent = date.toLocaleString('ja-JP', { year: 'numeric', month: 'long' }); // 年と月を表示

        const firstDay = new Date(date.getFullYear(), date.getMonth(), 1).getDay(); // 1日目の曜日
        const lastDate = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate(); // 月の最終日

        let dayCount = 1;
        let rows = Math.ceil((firstDay + lastDate) / 7); // 行数を決定

        for (let i = 0; i < rows; i++) {
            const row = document.createElement('tr'); // 行を作成
            for (let j = 0; j < 7; j++) {
                const cell = document.createElement('td'); // 日付セルを作成
                if (i === 0 && j < firstDay) {
                    row.appendChild(cell); // 最初の行で曜日に満たない部分を空白に
                    continue;
                }
                if (dayCount > lastDate) {
                    row.appendChild(cell);
                    continue;
                }

                const dateText = document.createElement('span');
                dateText.textContent = dayCount;
                cell.appendChild(dateText);  // 日付を表示
                cell.setAttribute('data-day', dayCount); // 日付データを設定
                row.appendChild(cell);
                dayCount++;
            }
            calendarBody.appendChild(row); // 行をカレンダーに追加
        }
        // displayStarOnCalendar(fetchedData); 
    }

    generateCalendar(currentDate); // 初期表示


    // ★マークを表示する関数
    function displayStarOnCalendar(data) {
        data.forEach(item => {
            const regiDate = new Date(item.regiDate); // regDateを日付オブジェクトに変換
            const year = regiDate.getFullYear();
            const month = regiDate.getMonth();
            const day = regiDate.getDate();

            // カレンダーの該当日付セルを取得
            if (year === currentDate.getFullYear() && month === currentDate.getMonth()) {
                const cell = document.querySelector(`#calendar-body td[data-day="${day}"]`);
                if (cell) {
                    const star = document.createElement('span'); // ★マークを作成
                    star.textContent = '★';
                    star.style.color = '#f39c12'; 
                    cell.appendChild(star); 
                }
            }
        });
    }

    // データ取得後にカレンダーに反映
    function fetchAndDisplayData() {
        $.ajax({
            url: '/grad_v1/modal2.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('AJAXレスポンス:', response); 
                if (response.status === 'success' && Array.isArray(response.data)) {
                    generateCalendar(currentDate); 
                    displayStarOnCalendar(response.data); 
                } else {
                    console.error('データ取得エラー:', response.message); 
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAXリクエストエラー:', xhr, status, error);
                alert('AJAXリクエストエラー: ' + status + ' - ' + error);
            }
        });
    }

    fetchAndDisplayData();

        // 前月ボタン
        prevMonth.addEventListener('click', function () {
            currentDate.setMonth(currentDate.getMonth() - 1); 
            fetchAndDisplayData(); 
            checkNextMonthButton(); 
        });
    
        // 翌月ボタン
        nextMonth.addEventListener('click', function () {
            currentDate.setMonth(currentDate.getMonth() + 1); 
            fetchAndDisplayData(); 
            checkNextMonthButton(); 
        });
    
        // 翌月ボタンが押せないようにする条件をチェックする関数
        function checkNextMonthButton() {
            const today = new Date();
            if (currentDate.getFullYear() > today.getFullYear() || (currentDate.getFullYear() === today.getFullYear() && currentDate.getMonth() >= today.getMonth())) {
                nextMonth.disabled = true; 
            } else {
                nextMonth.disabled = false; 
            }
        }
    
        checkNextMonthButton(); 
    });





