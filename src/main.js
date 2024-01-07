
import './css/styles.css';
import App from './ui/App.svelte';

// import '@material/theme/dist/mdc.theme.css';
// import 'svelte-material-ui/bare.css';

let e = document.getElementById('app-container');
e.innerHTML = '';
const app = new App({
	target: document.getElementById('app-container'),
	props: {}
});

export default app;
