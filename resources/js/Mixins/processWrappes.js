export default {
    data:()=>({
        ongoingProcess:false
    }),
    methods:{
        async wrapWithinProcess(clb){
            if (this.ongoingProcess){
                return;
            }
            this.ongoingProcess = true;
            await clb();
            this.ongoingProcess = false;

        }
    }
}
