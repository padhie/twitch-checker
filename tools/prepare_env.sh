cp .env.dist .env

sed -i 's/TWITCH_CLIENT_ID=xxx/TWITCH_CLIENT_ID=abc/g' .env
sed -i 's/TWITCH_SECRET=xxx/TWITCH_SECRET=def/g' .env
sed -i 's/TWITCH_REDIRECT_URL=xxx/TWITCH_REDIRECT_URL=ghi/g' .env
sed -i 's/TWITCH_ACCESS_TOKEN=xxx/TWITCH_ACCESS_TOKEN=jkl/g' .env
