# Reply Rephraser - WordPress Plugin

A simple WordPress plugin to send content to ChatGPT and return rephrased text in **simple English**, with **corrected grammar**, a **friendly human tone**, and **Markdown formatting**.

---

## 🚀 Usage

1. **Add OpenAI API Key**  
   Open `reply-rephraser.php` and replace `'Enter your API key here'` inside the `reply_get_rephrased_text()` function with your OpenAI API key.

2. **Upload Plugin**  
   Upload the `reply-rephraser` folder to your WordPress `wp-content/plugins/` directory.

3. **Activate Plugin**  
   Go to **WordPress Admin → Plugins**, find **Reply Rephraser**, and click **Activate**.

4. **Use the Plugin**  
   - Navigate to **Reply Rephraser** in the WordPress admin menu.  
   - Paste the text you want to rephrase into the textarea.  
   - Click **Rephrase** → your text will appear nicely formatted with Markdown, corrected grammar, and a friendly human tone.  

---

## 📝 Features

- Rephrase text into **simple English**.  
- Corrects **grammar and punctuation**.  
- Maintains a **friendly human tone**.  
- Supports **Markdown formatting** (bold, italics, lists).  
- Adds a **friendly greeting** and **apology** if missing.  
- Ends messages with **Best regards, <Your Name>**.  
- **Copy to clipboard** button for easy use.  

---

## ⚡ Notes

- Ensure you have a valid **OpenAI API key** and sufficient quota.  
- `Parsedown.php` must be present in the plugin folder for Markdown rendering.  

---

## 📜 License

MIT License. Free to use and modify.


