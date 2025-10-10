<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of published blogs for public
     */
    public function publicIndex()
    {
        $blogs = Blog::where('status', 'published')
                    ->whereNotNull('tanggal_upload')
                    ->orderBy('id_blog', 'desc')
                    ->paginate(10);

        return view('blogs.index', compact('blogs'));
    }

    /**
     * Display the specified blog
     */
    public function show($id_blog)
    {
        $blog = Blog::where('id_blog', $id_blog)
                    ->where('status', 'published')
                    ->firstOrFail();

        return view('blogs.show', compact('blog'));
    }

    /**
     * Display a listing for admin (drafts and published)
     */
    public function index()
    {
        // Draft urut pakai id_blog
        $drafts = Blog::where('status', 'draft')
                    ->orderBy('id_blog', 'desc')
                    ->paginate(5);

        // Recent artikel juga urut pakai id_blog
        $recents = Blog::where('status', 'published')
                    ->orderBy('id_blog', 'desc')
                    ->take(5)
                    ->get();

        return view('admin.blogs.index', compact('drafts', 'recents'));
    }

    /**
     * Store a newly created blog
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('blogs', 'public');
        }

        $validated['penulis'] = auth()->user()->name;
        $validated['status'] = $request->input('status', 'draft');
        $validated['id_user'] = auth()->id();

        // isi tanggal_upload hanya kalau publish
        if ($validated['status'] === 'published') {
            $validated['tanggal_upload'] = now();
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 
            $validated['status'] === 'published' 
                ? 'Artikel berhasil dipublish!' 
                : 'Artikel disimpan sebagai draft!'
        );
    }

    /**
     * Show the form for editing the specified blog
     */
    public function edit($id_blog)
    {
        $blog = Blog::findOrFail($id_blog);
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified blog
     */
    public function update(Request $request, $id_blog)
    {
        $blog = Blog::findOrFail($id_blog);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        // handle upload gambar baru
        if ($request->hasFile('gambar')) {
            if ($blog->gambar) {
                Storage::disk('public')->delete($blog->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('blogs', 'public');
        }

        // update status dari tombol
        $validated['status'] = $request->input('status', $blog->status);

        // kalau sebelumnya draft lalu dipublish → isi tanggal_upload
        if ($blog->status === 'draft' && $validated['status'] === 'published') {
            $validated['tanggal_upload'] = now();
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified blog
     */
    public function destroy($id_blog)
    {
        $blog = Blog::findOrFail($id_blog);

        if ($blog->gambar) {
            Storage::disk('public')->delete($blog->gambar);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Artikel berhasil dihapus!');
    }
}