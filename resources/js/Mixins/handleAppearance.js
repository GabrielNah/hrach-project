export default {
    methods:{
        properAppearance(appearance){
            if (!appearance){
                return {}
            }
            if (appearance.type==='color'){
                return {backgroundColor:appearance.value}
            }
            if (appearance.type==='image'){
                return {backgroundImage:'url(/'+appearance.value+')'}
            }
        }
    }
}
