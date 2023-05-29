// HEROメッセージエフェクト
window.addEventListener('DOMContentLoaded', (event) => {
    const message = document.querySelector('.message-container h1');
    let messageText = message.textContent;
    message.textContent = '';
    let i = 0;

    const messageb = document.querySelector('.message-container h2');
    let bmessageText = messageb.textContent;
    messageb.textContent = '';
    let b = 0;

    const typingEffectb = () => {
        if (b < bmessageText.length) {
            messageb.textContent += bmessageText[b];
            b++;
            setTimeout(typingEffectb, 200);
        }
    };

    const typingEffect = () => {
        if (i < messageText.length) {
            message.textContent += messageText[i];
            i++;
            setTimeout(typingEffect, 200);
        } else if (i == messageText.length) {
            typingEffectb();
        }
    };

    typingEffect();
});

// ブログ一覧サイドバーの位置変更
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

