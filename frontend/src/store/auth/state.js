export default function () {
  return {
    token: localStorage.getItem('api_token') || null,
  }
}
