#!/bin/bash
# Push to GitHub Helper Script

echo "=========================================="
echo "Push to GitHub - Helper Script"
echo "=========================================="
echo ""

# Get GitHub repository URL
read -p "Enter your GitHub repository URL (e.g., https://github.com/username/repo.git): " REPO_URL

if [ -z "$REPO_URL" ]; then
    echo "Error: Repository URL is required!"
    exit 1
fi

echo ""
echo "Adding remote repository..."
git remote add origin "$REPO_URL" 2>/dev/null || git remote set-url origin "$REPO_URL"

echo "Setting branch to main..."
git branch -M main

echo ""
echo "Pushing to GitHub..."
echo "You'll be asked for your GitHub username and password."
echo "Note: Use a Personal Access Token as password (not your GitHub password)"
echo ""
echo "To create a token:"
echo "1. Go to: https://github.com/settings/tokens"
echo "2. Click 'Generate new token (classic)'"
echo "3. Select scope: 'repo'"
echo "4. Copy the token and use it as password"
echo ""

git push -u origin main

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Success! Your code is now on GitHub!"
    echo ""
    echo "Next steps:"
    echo "1. Go to https://render.com"
    echo "2. Sign up with GitHub"
    echo "3. Create PostgreSQL database"
    echo "4. Create Web Service"
    echo "5. See SETUP_INSTRUCTIONS.md for details"
else
    echo ""
    echo "❌ Push failed. Check your credentials and try again."
fi

