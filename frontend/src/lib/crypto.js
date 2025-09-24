// src/utils/crypto.js
import CryptoJS from 'crypto-js'

const SECRET = 'my-secret-key' // keep it safe

export function encryptEmail(email) {
  return CryptoJS.AES.encrypt(email, SECRET).toString()
}

export function decryptEmail(cipherText) {
  const bytes = CryptoJS.AES.decrypt(cipherText, SECRET)
  return bytes.toString(CryptoJS.enc.Utf8)
}
