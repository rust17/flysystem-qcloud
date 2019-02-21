import UploadComponent from '../components/UploadFile'

export default {
  install: (Vue) => {
    const UploadFile = Vue.extend(UploadComponent)
    const vm = new UploadFile()
    const $el = vm.$mount().$el
    console.log($el)

    const upload = {}

    Vue.prototype.$upload = upload
  }
}
