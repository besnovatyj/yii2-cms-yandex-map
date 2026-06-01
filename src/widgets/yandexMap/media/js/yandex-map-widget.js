/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

document.addEventListener("DOMContentLoaded", () => {

    // https://habr.com/ru/articles/516700/

    // Контейнеры для добавления карт
    let map_containers = document.querySelectorAll('.yandex-map');

    map_containers.forEach((container) => {
        container.dataset.loaded = 'false';
        let listenerOptions = {
            once: true,
            passive: true,
            capture: true
        };
        addListenerMulti(container, 'click mouseover touchstart touchmove', start_lazy_map, listenerOptions);
    });

    function start_lazy_map() {

        const container = this;

        if (container.dataset.loaded === 'false') {
            initMap(container).catch(err => console.log(err));
        }

        container.dataset.loaded = 'true';
    }

    async function initMap(container) {

        const markers = JSON.parse(container.dataset.markers);
        const location = JSON.parse(container.dataset.location);

        await ymaps3.ready;
        ymaps3.strictMode = true;


        const {YMap, YMapDefaultSchemeLayer, YMapDefaultFeaturesLayer, YMapControls, YMapControlButton, YMapMarker} = ymaps3;
        const {YMapZoomControl} = await ymaps3.import('@yandex/ymaps3-controls@0.0.1');
        // Импорт пакета для добавления маркеров по-умолчанию
        const {YMapDefaultMarker} = await ymaps3.import('@yandex/ymaps3-markers@0.0.1');

        // Инициализация карты
        const map = new YMap(container, {location},
            [   // Добавление слоя схемы карты
                new YMapDefaultSchemeLayer({}),
                // Добавление слоя геообъектов для отображения маркеров
                new YMapDefaultFeaturesLayer({})
            ]);

        // Создание маркеров по умолчанию и добавление их на карту.
        markers.forEach((markerSource) => {
            const marker = new YMapDefaultMarker(markerSource);
            map.addChild(marker);
        });

        // Добавление элемента управления масштабом карты
        map.addChild(new YMapControls({position: 'right'}).addChild(new YMapZoomControl({})));

        // Добавьте контейнер для YMapControlButton и добавьте его на карту.
        const controls = new YMapControls({position: 'top right'});
        map.addChild(controls);

        // Создайте элемент div, который будет передан в YMapControlButton.
        const fullScreenElement = document.createElement('div');
        fullScreenElement.className = 'fullscreen';

        // Событие fullscreenchange запускается сразу после переключения браузера в полноэкранный режим или выхода из него.
        document.addEventListener('fullscreenchange', function () {
            container.classList.toggle('h-300'); /* Приходится выключать при переходе в полноэкранный режим */
            fullScreenElement.classList.toggle('exit-fullscreen');
        });

        function fullScreenBtnHandler() {
            // The document.fullscreenElement returns the Element that is currently being presented in fullscreen mode in this document, or null if fullscreen mode is not currently in use
            if (document.fullscreenElement) {
                // The document.exitFullscreen() requests that the element on this document which is currently being presented in fullscreen mode be taken out of fullscreen mode
                document.exitFullscreen();
            } else {
                // The element.requestFullscreen() method issues an asynchronous request to make the element be displayed in fullscreen mode
                map.container.requestFullscreen();
            }
        }

        // Add YMapControlButton that will enable or disable fullscreen mode
        const fullScreenBtn = new YMapControlButton({
            element: fullScreenElement,
            onClick: fullScreenBtnHandler
        });
        controls.addChild(fullScreenBtn);

        // Добавление пользовательского маркера
        // const markerElement = document.createElement('div');
        // markerElement.className = 'marker-class';
        // markerElement.innerText = "I'm marker!";
        // const marker = new YMapMarker(
        //     {
        //         coordinates: ['37.632197', '55.787255'],
        //         draggable: true,
        //         mapFollowsOnDrag: true
        //     },
        //     markerElement
        // );
        // map.addChild(marker);
    }

    /* Добавьте к элементу одного или нескольких слушателей - https://stackoverflow.com/a/8797106/24489536
    ** @param {DOMElement} element - Элемент DOM для добавления слушателей
    ** @param {string} eventNames - список названий событий, разделенных пробелами, например 'click change'
    ** @param {Function} listener - функция для подключения к каждому событию в качестве слушателя
    */
    function addListenerMulti(element, eventNames, listener, listenerOptions) {
        eventNames.split(' ').forEach(e => element.addEventListener(e, listener, listenerOptions));
    }

});
