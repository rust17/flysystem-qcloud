<template>
  <div class="panel flex justify-center mt-3">
    <form class="w-full max-w-sm">
      <div class="md:flex md:items-center mb-6">
        <div class="md:w-1/3">
          <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-file-name">fileName</label>
        </div>
        <div class="md:w-2/3">
          <input class="bg-grey-lighter appearance-none border-2 border-grey-lighter rounded w-full py-2 px-4 text-grey-darker leading-tight focus:outline-none focus:bg-white focus:border-purple" id="inline-file-name" v-model="filename">
        </div>
      </div>
      <div class="md:flex md:items-center mb-6">
        <div class="md:w-1/3">
          <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-file-size">fileSize</label>
        </div>
        <div class="md:w-2/3">
          <input class="bg-grey-lighter appearance-none border-2 border-grey-lighter rounded w-full py-2 px-4 text-grey-darker leading-tight focus:outline-none focus:bg-white focus:border-purple" disabled id="inline-file-size" value="">
        </div>
      </div>
      <div class="md:flex md:items-center mb-6">
        <div class="md:w-1/3">
          <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="last-modify-time">lastModifiedTime</label>
        </div>
        <div class="md:w-2/3">
          <input class="bg-grey-lighter appearance-none border-2 border-grey-lighter rounded w-full py-2 px-4 text-grey-darker leading-tight focus:outline-none focus:bg-white focus:border-purple" disabled id="last-modify-time" value="">
        </div>
      </div>
      <div class="md:flex md:items-center mb-6">
        <div class="md:w-1/3">
          <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="file-url">fileUrl</label>
        </div>
        <div class="md:w-2/3">
          <input class="bg-grey-lighter appearance-none border-2 border-grey-lighter rounded w-full py-2 px-4 text-grey-darker leading-tight focus:outline-none focus:bg-white focus:border-purple" disabled id="file-url" value="">
        </div>
      </div>
      <div class="md:flex md:items-center mb-6">
        <div class="md:w-1/3">
          <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="file-headers">fileHeader</label>
        </div>
        <div class="md:w-2/3">
          <input class="bg-grey-lighter appearance-none border-2 border-grey-lighter rounded w-full py-2 px-4 text-grey-darker leading-tight focus:outline-none focus:bg-white focus:border-purple" disabled id="file-headers" value="">
        </div>
      </div>
      <div class="md:flex md:items-center">
        <div class="md:w-1/3"></div>
        <div class="md:w-2/3" :class="{ hidden: isHidden }">
          <button class="shadow bg-purple hover:bg-purple-light focus:outline-none text-white font-bold py-2 px-4 rounded" type="button">Rename File</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'FileShow',
  data() {
    return {
      isHidden: true,
      filename: 'fileName',
      originFilename: 'fileName'
    }
  },
  watch: {
    filename(value) {
      if (value !== this.originFilename) {
        this.isHidden = false
      } else {
        this.isHidden = true
      }
    }
  }
}
</script>
