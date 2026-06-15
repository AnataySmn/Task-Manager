import { useState } from "react";
import api from "../services/api";
import { Link } from "react-router-dom";

export default function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  const handleLogin = async () => {
    try {
      setError("");

      const res = await api.post("/login", {
        email,
        password,
      });

      console.log("LOGIN RESPONSE:", res.data);

      // ✅ SAVE TOKEN
      localStorage.setItem("token", res.data.token);

          // ✅ SAVE ROLE (IMPORTANT)
      localStorage.setItem("role", res.data.user.role);

      // optional
      localStorage.setItem("user", JSON.stringify(res.data.user));

      console.log("TOKEN:", localStorage.getItem("token"));
      console.log("ROLE:", localStorage.getItem("role"));

      // redirect
      window.location.href = "/";

    } catch (err) {
      console.log(err.response?.data);
      setError(err.response?.data?.message || "Login failed");
    }
  };

  return (
    <div style={{ padding: 20 }}>
      <h2>Login</h2>

      <input
        placeholder="Email"
        value={email}
        onChange={(e) => setEmail(e.target.value)}
      />
      <br /><br />

      <input
        placeholder="Password"
        type="password"
        value={password}
        onChange={(e) => setPassword(e.target.value)}
      />
      <br /><br />

      <button onClick={handleLogin}>Login</button>

      {error && <p style={{ color: "red" }}>{error}</p>}
      <p>
      Don’t have an account? <Link to="/register">Sign up</Link>
      </p>
    </div>
  );
}