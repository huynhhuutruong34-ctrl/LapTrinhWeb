import { Link } from "react-router-dom";

export default function Placeholder({ title, description }: { title: string; description?: string }) {
  return (
    <section className="container mx-auto px-4 py-24 text-center">
      <h1 className="text-3xl font-bold tracking-tight">{title}</h1>
      {description && (
        <p className="mt-2 text-muted-foreground max-w-2xl mx-auto">{description}</p>
      )}
      <div className="mt-6">
        <Link to="/" className="inline-flex items-center gap-2 rounded-md border px-4 py-2 text-sm hover:bg-accent">
          ← Quay về trang chủ
        </Link>
      </div>
    </section>
  );
}
