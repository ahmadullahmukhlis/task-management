// src/utils/crypto.js
import CryptoJS from 'crypto-js'

// get key from env
const SECRET = import.meta.env.VITE_ENCRYPTION_KEY

export function LocalEncrypt(data) {
  return CryptoJS.AES.encrypt(data, SECRET).toString()
}

export function lOCALdecrypt(cipherText) {
  const bytes = CryptoJS.AES.decrypt(cipherText, SECRET)
  return bytes.toString(CryptoJS.enc.Utf8)
}
