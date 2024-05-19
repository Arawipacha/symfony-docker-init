import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import vuePlugin from "@vitejs/plugin-vue";
/* if you're using React */
// import react from '@vitejs/plugin-react';

export default defineConfig({
    server:{
        host: '0.0.0.0'
    },
    plugins: [
        /* react(), // if you're using React */
        vuePlugin(), 
        symfonyPlugin({
            // as we set `server.host` to 0.0.0.0
            // we must explicitly set the server host name
            viteDevServerHostname: 'localhost'
        }),
    ],
    optimizeDeps: {
        entries: [],
    },
    build: {
        //outDir: 'public/custom-build',
        rollupOptions: {
            input: {
                app: "./assets/app.ts",
                gantt: "./assets/vue/gantt/main.ts"
            },
            //external:['./assets/conytrollers/*.*','./assets/bootstrap.js']
            
        },
        
    
    },
    
});
