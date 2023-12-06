import './bootstrap';
import '../css/app.css';
import "../css/theme.css";
import "../css/font.css";
import "perfect-scrollbar/css/perfect-scrollbar.css";
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;

import Sortable from 'sortablejs';
window.Sortable = Sortable;

import editorjs from './editorjs'

import PerfectScrollbar from "perfect-scrollbar";
window.PerfectScrollbar = PerfectScrollbar;

Alpine.data('mainState', () => {
    const enableTheme = (isRtl) => {
        document.body.dir = isRtl ? 'rtl' : 'ltr';
    };

    const loadingMask = {
        pageLoaded: false,
        showText: false,
        init() {
            window.onload = () => {
                this.pageLoaded = true;
            };
            this.animateCharge();
        },
        animateCharge() {
            setInterval(() => {
                this.showText = true;
                setTimeout(() => {
                    this.showText = false;
                }, 2000);
            }, 4000);
        },
    };

    const getTheme = () => {
        return window.localStorage.getItem('dark') === 'true' ||
            (!!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
    };

    const setTheme = (value) => {
        window.localStorage.setItem('dark', value);
    };

    const handleOutsideClick = (event) => {
        if (
            this.isSidebarOpen &&
            !event.target.closest(".sidebar") &&
            !event.target.closest(".sidebar-toggle")
        ) {
            this.isSidebarOpen = false;
        }
    };

    document.addEventListener("click", handleOutsideClick);


    enableTheme(false); // sets document.body.dir to "ltr"

    return {
        isRtl: false,
        toggleRtl() {
            this.isRtl = !this.isRtl;
            enableTheme(this.isRtl);
            window.localStorage.setItem('rtl', this.isRtl);
        },
        loadingMask,
        isDarkMode: getTheme(),
        toggleTheme() {
            this.isDarkMode = !this.isDarkMode;
            setTheme(this.isDarkMode);
        },
        isSidebarOpen: sessionStorage.getItem('sidebarOpen') === 'true',
        isRightSidebarOpen: sessionStorage.getItem('rightSidebarOpen') === 'true',
        handleSidebarToggle() {
            this.isSidebarOpen = !this.isSidebarOpen;
            sessionStorage.setItem('sidebarOpen', this.isSidebarOpen.toString());
        },
        handleRightSidebarToggle() {
            this.isRightSidebarOpen = !this.isRightSidebarOpen;
            sessionStorage.setItem('rightSidebarOpen', this.isRightSidebarOpen.toString());
        },
        closeSidebarOnMobile() {
            if (window.innerWidth < 1024) {
                this.isSidebarOpen = false;
                this.isRightSidebarOpen = false;
            }
        },
        isSidebarHovered: false,
        handleSidebarHover(value) {
            if (window.innerWidth < 1024) {
                return;
            }
            this.isSidebarHovered = value;
        },
        handleWindowResize() {
            if (window.innerWidth <= 1024) {
                this.isSidebarOpen = false;
                this.isRightSidebarOpen = false;
            } else {
                this.isSidebarOpen = true;
                this.isRightSidebarOpen = false;
            }
        },
        scrollingDown: false,
        scrollingUp: false,
    };
});

Livewire.start();