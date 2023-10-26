<div>
    <div wire:poll.1000ms>
        <div x-data="{ currentPart: 0, content: @entangle('content') }" :style="'background-color: ' + content[currentPart].backgroundColor">
            @if ($content)
                @foreach ($content as $key => $part)
                    <div x-show="currentPart === {{ $key }}" transition.duration.500ms>
                        <p>{{ $part['text'] }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div>
        <MyVideo :content="content" />
    </div>

    @push('scripts')
        <script>
            function changePart(step) {
                const currentPart = parseInt(this.currentPart);
                const newPart = Math.max(0, Math.min(content.length - 1, currentPart + step));
                this.currentPart = newPart;
            }
        </script>
        <script>
        import {
            Composition,
            useVideoConfig,
            Sequence,
            Text,
            View,
            Image,
            BulletList
        } from 'remotion';
        
        const MyVideo = ({ content }) => {
            const { width, height, durationInFrames } = useVideoConfig();
        
            return (
                <Composition width={width} height={height} durationInFrames={durationInFrames}>
                    {content.map((part, index) => (
                        <Sequence key={index} from={part.durationInFrames * index} durationInFrames={part.durationInFrames}>
                            <View >
                                <Text fontSize={40}>{part.text}</Text>
                                <BulletList>
                                    {/* Add your bullet points here */}
                                    <Text fontSize={20}>Bullet point 1</Text>
                                    <Text fontSize={20}>Bullet point 2</Text>
                                    <Text fontSize={20}>Bullet point 3</Text>
                                </BulletList>
                            </View>
                        </Sequence>
                    ))}
                </Composition>
            );
        };
        export default MyVideo;
        </script>
    @endpush

</div>
