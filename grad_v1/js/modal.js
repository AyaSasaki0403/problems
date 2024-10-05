let modal;

document.addEventListener('DOMContentLoaded', function () {
    console.log("modal.js has been loaded successfully.");

    modal = document.getElementById("memoryModal");

    const openBtnHeader = document.getElementById("openMemoryModal"); // Header button
    const openBtnContent = document.getElementById("openMemoryModal2"); // Header button
    const closeBtn = document.getElementsByClassName("close")[0];

    // ヘッダーボタンがクリックされた時にモーダルを表示
    if (openBtnHeader) {
        openBtnHeader.addEventListener('click', function (event) {
            event.preventDefault();
            modal.style.display = "block";
        });
    }

    // コンテンツボタンがクリックされた時にモーダルを表示
    if (openBtnContent) {
        openBtnContent.addEventListener('click', function () {
            modal.style.display = "block";
        });
    }

    // 閉じるボタンがクリックされた時にモーダルを非表示
    closeBtn.addEventListener('click', function () {
        modal.style.display = "none";
        clearModalFields(); // フィールドをクリアする関数を呼び出す
    });

    // モーダルの外側をクリックした時にモーダルを非表示
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
            clearModalFields(); // フィールドをクリアする関数を呼び出す
        }
    });

// フィールドをクリアする関数
function clearModalFields() {
    $("#regiDate").val('');
    $("#place").val('');
    $("#withWho").val('');
    $("#publish").prop('checked', false);
    $("#memo").val('');
    $("#image").val('');
    $("#imagePreview").attr('src', '').hide(); // プレビュー画像を非表示にしてクリア
}

// Image preview functionality
document.getElementById('image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagePreview').src = '';
        document.getElementById('imagePreview').style.display = 'none';
    }
});

// データ取得と表示
function fetchAndDisplayData() {
    $.ajax({
        url: '/grad_v1/modal2.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('AJAXレスポンス:', response); // ここでレスポンス全体を確認
            if (response.status === 'success' && Array.isArray(response.data)) {
                console.log('Calling displayStarOnCalendar with:', response.data); // ここで確認
                displayStarOnCalendar(response.data); // ★マークをカレンダーに表示
            } else {
                console.error('データ取得エラー:', response.message);
                alert('データ取得に失敗しました: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAXリクエストエラー:', xhr, status, error);
            alert('AJAXリクエストエラー: ' + status + ' - ' + error);
        }
    });
}

// モーダルに投稿内容を表示する関数
function openModalWithData(item) {
    $("#regiDate").val(item.regiDate);
    $("#place").val(item.place);
    $("#withWho").val(item.withWho);
    $("#publish").prop('checked', item.publish == 1);
    $("#memo").val(item.memo);

    // 画像プレビューの表示
    const imagePreview = document.getElementById('imagePreview');
    if (item.image) {
        imagePreview.src = item.image;
        imagePreview.style.display = 'block';
    } else {
        imagePreview.src = '';
        imagePreview.style.display = 'none';
    }

    // モーダルの表示
    modal.style.display = "block";
}

   // saving data
document.getElementById('save').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default form submission behavior

    // Collect form data
    const formData = new FormData();
    formData.append('regiDate', document.getElementById('regiDate').value);
    formData.append('place', document.getElementById('place').value);
    formData.append('withWho', document.getElementById('withWho').value);
    formData.append('publish', document.getElementById('publish').checked ? 1 : 0);
    formData.append('memo', document.getElementById('memo').value);

    const imageFile = document.getElementById('image').files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }

    // AJAX request to post data
    $.ajax({
        url: '/grad_v1/modal2.php', // Update this URL if needed
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                alert('データが正常に登録されました');
                modal.style.display = 'none'; // Close the modal
                clearModalFields(); // モーダルフィールドをクリア
                fetchAndDisplayData(); // Reload data display
            } else {
                alert('データ登録に失敗しました: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAXリクエストエラー:', xhr, status, error);
            alert('データ登録時にエラーが発生しました');
        }
    });
});
});

    // データ取得と表示
    function fetchAndDisplayData() {
        $.ajax({
            url: '/grad_v1/modal2.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('AJAXレスポンス:', response);
                if (response.status === 'success' && Array.isArray(response.data)) {
                    displayData(response.data);
                } else {
                    console.error('データ取得エラー:', response.message);
                    alert('データ取得に失敗しました: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAXリクエストエラー:', xhr, status, error);
                alert('AJAXリクエストエラー: ' + status + ' - ' + error);
            }
        });
    }

    // データを表示する関数
    function displayData(data) {
        console.log('データ:', data);
        const displayArea = document.getElementById('data-display-area');
        displayArea.innerHTML = ''; // 既存の内容をクリア
    
        data.forEach(item => {
            const div = document.createElement('div');
            div.classList.add('memory-item', 'data-display');
            div.setAttribute('data-id', item.id);
    
            // itemの内容を表示
            div.innerHTML = `
                <div class="data-image"><img src="${item.image}" alt="Memory Image" style="max-width: 200px;"></div>
                <div class="data-details">
                    <p><strong>登録日:</strong> ${item.regiDate}</p>
                    <p><strong>場所:</strong> ${item.place}</p>
                    <p><strong>誰と:</strong> ${item.withWho}</p>
                    <p><strong>メモ:</strong> ${item.memo}</p>
                    <button class="edit-btn">編集</button>
                    <button class="delete-btn">削除</button>
                </div>
            `;
            displayArea.appendChild(div);
        });
    }
    fetchAndDisplayData();

       // イベントリスナーを追加する関数
       function addEventListeners() {
        // 編集ボタンにイベントリスナーを追加
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('edit-btn')) {
                const itemDiv = event.target.closest('.memory-item');
                const itemId = itemDiv.getAttribute('data-id');
        // document.querySelectorAll('.edit-btn').forEach(button => {
        //     button.addEventListener('click', function () {
        //         const itemDiv = this.closest('.memory-item');
        //         const itemId = itemDiv.getAttribute('data-id');
    
                // AJAXリクエストでデータを取得してモーダルに表示
                $.ajax({
                    url: '/grad_v1/get_memory.php', // IDに基づいてデータを取得するAPI
                    type: 'GET',
                    data: { id: itemId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const selectedItem = response.data;
                            $("#regiDate").val(selectedItem.regiDate);
                            $("#place").val(selectedItem.place);
                            $("#withWho").val(selectedItem.withWho);
                            $("#publish").prop('checked', selectedItem.publish == 1);
                            $("#memo").val(selectedItem.memo);
    
                            // プレビュー画像を表示
                            const imagePreview = document.getElementById('imagePreview');
                            if (selectedItem.image) {
                                imagePreview.src = selectedItem.image;
                                imagePreview.style.display = 'block';
                            } else {
                                imagePreview.src = '';
                                imagePreview.style.display = 'none';
                            }
    
                            // モーダルの表示
                            modal.style.display = "block";
    
                            // 編集モードを示すデータ属性を保存
                            $("#save").data('edit-id', itemId);
                        } else {
                            alert('データ取得エラー: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAXリクエストエラー:', xhr, status, error);
                        alert('データ取得時にエラーが発生しました');
                    }
                });
            }
        });
    
        // 削除ボタンにイベントリスナーを追加
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-btn')) {
        // document.querySelectorAll('.delete-btn').forEach(button => {
        //     button.addEventListener('click', function () {

                const itemDiv = this.closest('.memory-item');
                const itemId = itemDiv.getAttribute('data-id');
    
                if (confirm('本当にこのデータを削除しますか？')) {
                    // AJAXリクエストでデータを削除
                    $.ajax({
                        url: '/grad_v1/delete_memory.php', // データ削除用のAPI
                        type: 'POST',
                        data: { id: itemId },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                itemDiv.remove(); // データ削除成功時にボックスを削除
                                alert('データが削除されました');
                            } else {
                                alert('データ削除に失敗しました: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAXリクエストエラー:', xhr, status, error);
                            alert('データ削除時にエラーが発生しました');
                        }
                    });
                }
            }
        });
    }
    
    // ページ読み込み時にデータを取得して表示
    fetchAndDisplayData();  
