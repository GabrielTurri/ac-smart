import { Route, Routes } from "react-router-dom";

import { Home } from "./pages/Home";
import { Dashboard } from "./pages/Dashboard";
import { ACLogin } from "./pages/ACLogin";

export function Router() {
  return (
    <Routes>
      <Route path="/" element={<Home />}/>
      <Route path="/aclogin" element={<ACLogin />}/>
      <Route path="/dashboard" element={<Dashboard />}/>
    </Routes>
  );
}