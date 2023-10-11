import { Improve my vitepress config } from './improve my vitepress config.ai.ts';

export class ImproveVitepressConfigImpl implements Improve my vitepress config {
  private plugins: string[];

  constructor() {
    this.plugins = [];
  }

  addPlugin(pluginName: string): void {
    if (!this.plugins.includes(pluginName)) {
      this.plugins.push(pluginName);
    } else {
      console.log(`Plugin ${pluginName} already exists.`);
    }
  }

  removePlugin(pluginName: string): void {
    const index = this.plugins.indexOf(pluginName);
    if (index !== -1) {
      this.plugins.splice(index, 1);
    } else {
      console.log(`Plugin ${pluginName} not found.`);
    }
  }

  getPlugins(): string[] {
    return this.plugins;
  }
}
// @cursor-agent {"dependsOn": "interface", "hash": "c45d3b94c594981fc47f2f5cce6909d254d4986cc8a5f03de2034b09740ab362"}
