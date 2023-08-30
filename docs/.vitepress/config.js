export default {
  base: '/docs/',
  dest: '/public/docs/',
  title: "MystockMaster",
  description: "Inventory management system built with TallStack",
  themeConfig: {
    logo: "/logo.svg",
    siteTitle: "MystockMaster",

    nav: [
      { text: 'Home', link: '/' },
      { text: 'Examples', link: '/markdown-examples' },
      { text: 'Documentation', link: '/guide/installation', target: '_self' },
      // { text: 'Demo', link: 'https://mystockmaster.zakarialabib.me', target: '_blank' },
      { text: 'GitHub', link: 'https://github.com/zakarialabib/mystockMaster' },

    ],

    sidebar: [
      {
        text: 'Get Started',
        collapsible: true,
        items: [
          { text: 'Introduction', link: '/guide/introduction' },
          { text: 'Features', link: '/guide/features' },
          { text: 'Installation', link: '/guide/installation' },
          { text: 'Configuration', link: '/guide/configuration' },
          { text: 'Environment', link: '/guide/environment' },
          { text: 'Usage', link: '/guide/usage' },
        ]
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/vuejs/vitepress' }
    ]
  }
}
