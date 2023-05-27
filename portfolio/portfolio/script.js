window.addEventListener('DOMContentLoaded', (event) => {
    // Bootstrapのmdブレークポイント
    const breakpoint = 768;

    // 移動させる要素
    const pastArticles = document.getElementById('past-articles');

    // 移動先の要素
    const sectionTop = document.getElementById('section-top');
    const sectionBottom = document.getElementById('section-bottom');

    // メディアクエリの作成
    const mediaQuery = window.matchMedia(`(max-width: ${breakpoint}px)`);

    // メディアクエリの状態に応じて要素を移動する関数
    function moveElement(e) {
        if (e.matches) {
            // ビューポートの幅がブレークポイント以下の場合、要素を#section-bottomに移動
            sectionBottom.appendChild(pastArticles);
        } else {
            // ビューポートの幅がブレークポイント以上の場合、要素を#section-topに移動
            sectionTop.appendChild(pastArticles);
        }
    }

    // ページ読み込み時に関数を実行
    moveElement(mediaQuery);

    // ビューポートの幅が変更されたときに関数を実行
    mediaQuery.addListener(moveElement);
});