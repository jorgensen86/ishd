import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

import $ from 'jquery'
window.jQuery = window.$ = $

// import './plugins/CardRefresh'
// import CardWidget from './plugins/CardWidget'
// import ControlSidebar from './plugins/ControlSidebar'
// import DirectChat from './plugins/DirectChat'
// import Dropdown from './plugins/Dropdown'
// import ExpandableTable from './plugins/ExpandableTable'
// import Fullscreen from './plugins/Fullscreen'
// import IFrame from './plugins/IFrame'
// import Layout from './plugins/Layout'
// import PushMenu from './plugins/PushMenu'
// import SidebarSearch from './plugins/SidebarSearch'
// import NavbarSearch from './plugins/NavbarSearch'
import  './plugins/Toasts'
// import TodoList from './plugins/TodoList'
// import Treeview from './plugins/Treeview'

import 'bootstrap-switch';


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import 'laravel-datatables-vite';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
