import UploadComponent from '../components/UploadFile'

export default {
  install: (Vue) => {
    const UploadFile = Vue.extend(UploadComponent)
    const vm = new UploadFile()
    const $el = vm.$mount().$el

    Vue.nextTick(() => {
      document.querySelector('#app').prepend($el)
    })

    vm.$on('update:show', (value) => {
      vm.show = value
    })

    const upload = {
      show() {
        vm.show = false

        Vue.nextTick(() => {
          vm.show = true
        })
      },
      hide() {
        Vue.nextTick(() => {
          vm.show = false
        })
      }
    }

    Vue.prototype.$upload = upload
  }
}
