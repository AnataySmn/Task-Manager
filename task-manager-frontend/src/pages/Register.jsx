import { useState } from "react";
import api from "../services/api";
import { useNavigate } from "react-router-dom";

export default function Register() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  const navigate = useNavigate();

  const handleRegister = async () => {
    try {
      setError("");

      const res = await api.post("/register", {
        name,
        email,
        password,
      });

      console.log("REGISTER:", res.data);

      // optional: auto login after register
      localStorage.setItem("token", res.data.token);
      localStorage.setItem("role", res.data.user.role);

      navigate("/");

    } catch (err) {
      console.log(err.response?.data);
      setError(err.response?.data?.message || "Registration failed");
    }
  };

  return (
    <div style={{ padding: 20 }}>
      <h2>Register</h2>

      <input placeholder="Name" value={name} onChange={(e) => setName(e.target.value)} />
      <br /><br />

      <input placeholder="Email" value={email} onChange={(e) => setEmail(e.target.value)} />
      <br /><br />

      <input
        placeholder="Password"
        type="password"
        value={password}
        onChange={(e) => setPassword(e.target.value)}
      />
      <br /><br />

      <button onClick={handleRegister}>Create Account</button>

      {error && <p style={{ color: "red" }}>{error}</p>}
    </div>
  );
}