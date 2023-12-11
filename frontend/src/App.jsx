import axios from "axios"
import { useEffect, useState } from "react"

export default function App() {
  const [question, setQuestion] = useState(null)
  const [isLoading, setIsLoading] = useState(true)
  useEffect(() => {
    axios.get('http://localhost:8081/Api').then((response) => {
      setQuestion(response.data['pernyataan siswa'])
    }).catch((error) => {
      console.log(error)
    }).finally(() => {
      setIsLoading(false)
    })
  }, [])

  return (
    isLoading != true &&
    <div className="w-full min-h-screen bg-slate-50">
      {
        question.map((value, index) => {
          return <p key={index}>{value.isi_pernyataan}</p>
        })
      }
    </div>
  )
}