package com.example.eventsact;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

public class EventsAdapter extends RecyclerView.Adapter<EventsAdapter.EventViewHolder> {
    private static int viewHolderCount;
    private List<Event> events;
    private Context parent;

    public EventsAdapter(Context parent, List<Event> eventArrayList) {
        events = eventArrayList;
        viewHolderCount = 0;
        this.parent = parent;
    }

    @NonNull
    @Override
    public EventViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        Context context = parent.getContext();
        int layoutIdForEvents = R.layout.event_preview;
        LayoutInflater inflater = LayoutInflater.from(context);
        View view = inflater.inflate(layoutIdForEvents, parent, false);
        EventViewHolder viewHolder = new EventViewHolder(view);
        viewHolderCount++;
        return viewHolder;
    }

    @Override
    public void onBindViewHolder(@NonNull EventViewHolder holder, int position) {
        Event currentEvent = events.get(position);
        String imageUrl = "https://images-na.ssl-images-amazon.com/images/I/71Qoz6QOT7L._AC_SL1010_.jpg";
        String title = currentEvent.getTitle();

        holder.eventTitle.setText(title);
        Picasso.get().load(imageUrl).fit().centerInside().into(holder.mImageView);
    }

    @Override
    public int getItemCount() {
        return events.size();
    }

    class EventViewHolder extends RecyclerView.ViewHolder {
        ImageView mImageView;
        TextView eventTitle;
        TextView viewHolderIndex;

        public EventViewHolder(@NonNull View itemView) {
            super(itemView);
            mImageView = itemView.findViewById(R.id.image_event);
            eventTitle = itemView.findViewById(R.id.events_title);
            viewHolderIndex = itemView.findViewById(R.id.tv_view_holder_number);

            itemView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    int positionIndex = getAdapterPosition();
                    Toast toast = Toast.makeText(parent, "Element " + positionIndex + " was clicked", Toast.LENGTH_SHORT);
                    toast.show();
                }
            });
        }

        void bind(int listEvent) {
            eventTitle.setText(String.valueOf(listEvent));
        }
    }
}
